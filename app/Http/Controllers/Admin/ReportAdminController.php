<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\ReportServiceInterface;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportAdminController extends Controller
{
    protected ReportServiceInterface $reportService;

    public function __construct(ReportServiceInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $reports = Report::with('admin')
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->start_date, function ($query, $startDate) {
                return $query->where('report_date', '>=', $startDate);
            })
            ->when($request->end_date, function ($query, $endDate) {
                return $query->where('report_date', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function analytics(Request $request)
    {
        $filters = $this->buildFilters($request);
        $analyticsData = $this->reportService->getAnalyticsData($filters);

        return view('admin.reports.analytics', compact('analyticsData', 'filters'));
    }

    public function show(Report $report)
    {
        $report->load('admin');

        return view('admin.reports.show', compact('report'));
    }

    public function generateDaily(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : null;

        $report = $this->reportService->generateDailyReport(auth()->id(), $date);

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Daily report generated successfully!');
    }

    public function generateWeekly(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : null;

        $report = $this->reportService->generateWeeklyReport(auth()->id(), $startDate);

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Weekly report generated successfully!');
    }

    public function generateMonthly(Request $request)
    {
        $month = $request->month ? Carbon::parse($request->month) : null;

        $report = $this->reportService->generateMonthlyReport(auth()->id(), $month);

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Monthly report generated successfully!');
    }

    public function exportPdf(Request $request)
    {
        $filters = $this->buildFilters($request);
        $analyticsData = $this->reportService->getAnalyticsData($filters);

        $pdf = Pdf::loadView('admin.reports.pdf', [
            'data' => $analyticsData,
            'filters' => $filters,
            'generatedAt' => now(),
        ]);

        return $pdf->download('report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters = $this->buildFilters($request);
        $analyticsData = $this->reportService->getAnalyticsData($filters);

        $reportTitle = 'Analytics Report';
        if ($request->start_date && $request->end_date) {
            $reportTitle .= ' (' . $request->start_date . ' to ' . $request->end_date . ')';
        }

        return Excel::download(
            new ReportExport($analyticsData, $reportTitle),
            'report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function destroy(Report $report)
    {
        if ($report->admin_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report deleted successfully!');
    }

    protected function buildFilters(Request $request): array
    {
        $filters = [];

        if ($request->start_date) {
            $filters['start_date'] = Carbon::parse($request->start_date)->startOfDay();
        }

        if ($request->end_date) {
            $filters['end_date'] = Carbon::parse($request->end_date)->endOfDay();
        }

        if ($request->food_type) {
            $filters['food_type'] = $request->food_type;
        }

        if ($request->location) {
            $filters['location'] = $request->location;
        }

        if ($request->status) {
            $filters['status'] = $request->status;
        }

        return $filters;
    }
}
