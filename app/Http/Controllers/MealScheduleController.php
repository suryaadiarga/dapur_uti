<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealScheduleRequest;
use App\Models\MealSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = MealSchedule::with('creator')
            ->filter($request->all())
            ->orderBy('schedule_date', 'desc')
            ->orderBy('shift', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('meal-schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('meal-schedules.form', ['mealSchedule' => new MealSchedule]);
    }

    public function store(MealScheduleRequest $request)
    {
        $data = $request->validated();
        
        // Gabungkan array menu menjadi string teks untuk disimpan ke kolom menu_items
        $data['menu_items'] = implode(', ', array_filter($data['menus']));
        
        // Hapus key 'menus' karena tidak ada kolomnya di tabel database
        unset($data['menus']);

        $data['created_by'] = Auth::id();

        MealSchedule::create($data);

        return redirect()->route('meal-schedules.index')->with('success', 'Jadwal makanan & order berhasil ditambahkan.');
    }

    public function edit(MealSchedule $mealSchedule)
    {
        return view('meal-schedules.form', compact('mealSchedule'));
    }

    public function update(MealScheduleRequest $request, MealSchedule $mealSchedule)
    {
        $data = $request->validated();
        
        // Update string teks dari array input dinamis
        $data['menu_items'] = implode(', ', array_filter($data['menus']));
        
        // Hapus key 'menus' agar tidak ikut di-update ke database
        unset($data['menus']);
        
        $mealSchedule->update($data);

        return redirect()->route('meal-schedules.index')->with('success', 'Jadwal makanan & order berhasil diperbarui.');
    }

    public function destroy(MealSchedule $mealSchedule)
    {
        $mealSchedule->delete();
        
        return redirect()->route('meal-schedules.index')->with('success', 'Jadwal makanan & order berhasil dihapus.');
    }
}