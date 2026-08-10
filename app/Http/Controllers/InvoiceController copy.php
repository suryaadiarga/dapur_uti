<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MealSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('creator')->orderBy('created_at', 'desc')->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'notes'      => 'nullable|string',
        ]);

        // Ambil data meal schedules berdasarkan rentang tanggal
        $schedules = MealSchedule::whereBetween('schedule_date', [$request->start_date, $request->end_date])->get();

        if ($schedules->isEmpty()) {
            return back()->withErrors(['start_date' => 'Tidak ada jadwal makanan ditemukan pada rentang tanggal tersebut.'])->withInput();
        }

        // Kalkulasi otomatis total porsi dan total estimasi biaya
        $totalPortions = $schedules->sum('portion_count');
        $totalAmount   = $schedules->sum('estimated_cost');

        // Buat nomor invoice otomatis
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        Invoice::create([
            'invoice_number' => $invoiceNumber,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'total_portions' => $totalPortions,
            'total_amount'   => $totalAmount,
            'status'         => 'unpaid',
            'notes'          => $request->notes,
            'created_by'     => Auth::id(),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice otomatis berhasil digenerate.');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'paid',
        ]);

        return back()->with('success', 'Status invoice berhasil diubah menjadi Paid.');
    }

    public function show(Invoice $invoice)
    {
        // Ambil rincian jadwal yang masuk ke dalam rentang invoice ini
        $schedules = MealSchedule::whereBetween('schedule_date', [$invoice->start_date, $invoice->end_date])
            ->orderBy('schedule_date', 'asc')
            ->orderBy('shift', 'asc')
            ->get();

        return view('invoices.show', compact('invoice', 'schedules'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }
}