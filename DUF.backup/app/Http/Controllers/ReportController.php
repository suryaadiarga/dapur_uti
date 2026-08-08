<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Setting;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request, ReportService $service)
    {
        $filters = $this->validatedFilters($request);

        return view('reports.index', ['report' => $service->build($filters, $request->user())]);
    }

    public function pdf(Request $request, ReportService $service)
    {
        $report = $service->build($this->validatedFilters($request), $request->user());
        $pdf = Pdf::loadView('reports.pdf', ['report' => $report, 'setting' => Setting::current()])
            ->setPaper('a4', 'landscape');

        return $pdf->download($this->filename($report, 'pdf'));
    }

    public function excel(Request $request, ReportService $service)
    {
        $report = $service->build($this->validatedFilters($request), $request->user());

        return Excel::download(new ReportExport($report['headings'], $report['rows']), $this->filename($report, 'xlsx'));
    }

    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'type' => ['nullable', Rule::in(array_keys(ReportService::TYPES))],
            'period' => ['nullable', Rule::in(['today', 'week', 'month', 'year', 'custom'])],
            'date_from' => ['nullable', 'required_if:period,custom', 'date'],
            'date_to' => ['nullable', 'required_if:period,custom', 'date', 'after_or_equal:date_from'],
        ]);
    }

    private function filename(array $report, string $extension): string
    {
        return str($report['title'])->slug().'-'.now()->format('Ymd-His').'.'.$extension;
    }
}
