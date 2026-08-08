<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with('person', 'creator')
            ->filter($request->all())
            ->latest('attendance_date')
            ->paginate(15)
            ->withQueryString();

        $people = Person::orderBy('name')->get();

        return view('attendances.index', compact('attendances', 'people'));
    }

    public function create()
    {
        $people = Person::orderBy('name')->get();
        return view('attendances.form', ['attendance' => new Attendance, 'people' => $people]);
    }

    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        Attendance::create($data);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
    {
        $people = Person::orderBy('name')->get();
        return view('attendances.form', compact('attendance', 'people'));
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}