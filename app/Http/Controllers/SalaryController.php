<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Attendance;
use App\Models\ExpenseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with(['person', 'attendance', 'creator'])->orderBy('salary_date', 'desc')->paginate(15);
        
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

        if (!$attendanceId) {
            return redirect()->route('salaries.index')->with('error', 'Silakan pilih data absensi terlebih dahulu.');
        }

        $attendance = Attendance::with('person')->findOrFail($attendanceId);

        return view('salaries.create', compact('attendance'));
    }

    public function store(Request $request, ImageService $imageService)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'amount'        => 'required|numeric|min:0',
            'salary_date'   => 'required|date',
            'proof_photo'   => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'signature'     => 'nullable|string', 
            'notes'         => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($request->attendance_id);

        $photoPath = null;
        if ($request->hasFile('proof_photo')) {
            // BOOM! Sisa 1 baris kode saja untuk menangani semua logika gambar yang rumit!
            $photoPath = $imageService->uploadAndCompress($request->file('proof_photo'), 'salary-proofs');
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

        // 2. Otomatis tambah ke ExpenseTransaction
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
        if ($salary->proof_photo) {
            Storage::disk('public')->delete($salary->proof_photo);
        }

        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}