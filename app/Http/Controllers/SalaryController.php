<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Attendance;
use App\Models\ExpenseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class SalaryController extends Controller
{
    public function index()
    {
        // Ambil daftar gaji yang sudah dibayar
        $salaries = Salary::with(['person', 'attendance', 'creator'])->orderBy('salary_date', 'desc')->paginate(15);
        
        // Ambil absensi hadir yang belum dibayar gajinya
        $pendingAttendances = Attendance::where('status', 'hadir')
            ->whereDoesntHave('salary')
            ->with('person')
            ->orderBy('attendance_date', 'desc')
            ->paginate(15);

        return view('salaries.index', compact('salaries', 'pendingAttendances'));
    }

    public function create(Request $request)
    {
        $attendanceId = $request->query('attendance_id');

        // PENGAMAN: Jika diakses tanpa parameter attendance_id, kembalikan ke index
        if (!$attendanceId) {
            return redirect()->route('salaries.index')->with('error', 'Silakan pilih data absensi terlebih dahulu.');
        }

        $attendance = Attendance::with('person')->findOrFail($attendanceId);

        return view('salaries.create', compact('attendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'amount'        => 'required|numeric|min:0',
            'salary_date'   => 'required|date',
            'proof_photo'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature'     => 'nullable|string', // Menerima data base64 tanda tangan
            'notes'         => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($request->attendance_id);

        // Handle upload foto bukti jika ada
        $photoPath = null;
        if ($request->hasFile('proof_photo')) 
        {
            $file = $request->file('proof_photo');
            
            // Buat nama file unik berformat .jpg
            $filename = 'salary-proofs/' . time() . '_' . uniqid() . '.jpg';
            
            // Pastikan direktori storage/app/public/salary-proofs ada
            $destinationPath = storage_path('app/public/salary-proofs');
            if (!file_exists($destinationPath)) 
            {
                mkdir($destinationPath, 0755, true);
            }

            // Proses kompresi dengan Intervention Image v4
            $manager = ImageManager::usingDriver(Driver::class);
            $image = $manager->decodePath($file->getRealPath());
            
            // Sesuaikan lebar maksimal misal 1000px agar ukuran file drastis turun & proporsional
            $image->scale(width: 1000); 
            
            // Encode ke format JPEG dengan kualitas 75% lalu simpan secara fisik
            $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 75);
            $encoded->save(storage_path('app/public/' . $filename));

            // Path yang disimpan ke database (bisa diakses via asset('storage/' . $photoPath))
            $photoPath = $filename;
        }

        // 1. Simpan Data Gaji
        $salary = Salary::create([
            'attendance_id' => $attendance->id,
            'person_id'     => $attendance->people_id, 
            'salary_date'   => $request->salary_date,
            'amount'        => $request->amount,
            'proof_photo'   => $photoPath,
            'signature'     => $request->signature,
            'status'        => 'paid',
            'notes'         => $request->notes,
            'created_by'    => Auth::id(),
        ]);

        // 2. OTOMATIS TAMBAHKAN KE TABEL EXPENSE_TRANSACTIONS (Sesuai Fillable Model ExpenseTransaction)
        ExpenseTransaction::create([
            'transaction_date' => $request->salary_date,
            'people_id'        => $attendance->people_id,
            'category'         => 'gaji',
            'amount'           => $request->amount,
            'payment_method'   => 'tunai',
            'store_name'       => '-',
            'description'      => 'Pembayaran Gaji Karyawan: ' . ($attendance->person->name ?? 'Staff') . '. Catatan: ' . $request->notes,
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('salaries.index')->with('success', 'Gaji karyawan berhasil disimpan dan otomatis menambah data pengeluaran.');
    }

    public function destroy(Salary $salary)
    {
        // Hapus file foto bukti jika ada
        if ($salary->proof_photo) {
            Storage::disk('public')->delete($salary->proof_photo);
        }

        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}