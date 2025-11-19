<?php

namespace App\Services;

use App\Contracts\Services\ReportServiceInterface;
use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceInterface
{
    public function generate(int $adminId, string $title, string $content): Report
    {
        return Report::create([
            'admin_id' => $adminId,
            'type' => 'manual',
            'title' => $title,
            'content' => $content,
            'created_at' => now(),
        ]);
    }

    public function listByAdmin(int $adminId, int $perPage = 15)
    {
        return Report::where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function generateDailyReport(int $adminId, ?\DateTime $date = null): Report
    {
        $date = $date ? Carbon::instance($date) : Carbon::today();

        $data = $this->getAnalyticsData([
            'start_date' => $date->startOfDay(),
            'end_date' => $date->endOfDay(),
        ]);

        $content = $this->formatDailyReportContent($data);

        return Report::create([
            'admin_id' => $adminId,
            'type' => 'daily',
            'title' => 'Daily Report - ' . $date->format('Y-m-d'),
            'content' => $content,
            'data' => $data,
            'report_date' => $date,
            'created_at' => now(),
        ]);
    }

    public function generateWeeklyReport(int $adminId, ?\DateTime $startDate = null): Report
    {
        $startDate = $startDate ? Carbon::instance($startDate) : Carbon::now()->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();

        $data = $this->getAnalyticsData([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $content = $this->formatWeeklyReportContent($data, $startDate, $endDate);

        return Report::create([
            'admin_id' => $adminId,
            'type' => 'weekly',
            'title' => 'Weekly Report - ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'),
            'content' => $content,
            'data' => $data,
            'report_date' => $startDate,
            'created_at' => now(),
        ]);
    }

    public function generateMonthlyReport(int $adminId, ?\DateTime $month = null): Report
    {
        $month = $month ? Carbon::instance($month) : Carbon::now();
        $startDate = $month->copy()->startOfMonth();
        $endDate = $month->copy()->endOfMonth();

        $data = $this->getAnalyticsData([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $content = $this->formatMonthlyReportContent($data, $month);

        return Report::create([
            'admin_id' => $adminId,
            'type' => 'monthly',
            'title' => 'Monthly Report - ' . $month->format('F Y'),
            'content' => $content,
            'data' => $data,
            'report_date' => $startDate,
            'created_at' => now(),
        ]);
    }

    public function getAnalyticsData(array $filters = []): array
    {
        return [
            'donations' => $this->getDonationStats($filters),
            'matching' => $this->getMatchingStats($filters),
            'delivery' => $this->getDeliveryStats($filters),
            'food_types' => $this->getFoodTypeDistribution($filters)->toArray(),
            'locations' => $this->getLocationStats($filters)->toArray(),
            'users' => $this->getUserStats($filters),
        ];
    }

    public function getDonationStats(array $filters = []): array
    {
        $query = Donation::query();

        $this->applyDateFilters($query, $filters);

        $total = $query->count();
        $totalQuantity = $query->sum('quantity');

        $byStatus = Donation::query();
        $this->applyDateFilters($byStatus, $filters);
        $byStatus = $byStatus->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $overTime = Donation::query();
        $this->applyDateFilters($overTime, $filters);
        $overTime = $overTime->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count'),
                DB::raw('sum(quantity) as total_quantity')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();

        return [
            'total' => $total,
            'total_quantity' => $totalQuantity,
            'by_status' => $byStatus,
            'over_time' => $overTime,
        ];
    }

    public function getMatchingStats(array $filters = []): array
    {
        $requestQuery = FoodRequest::query();
        $this->applyDateFilters($requestQuery, $filters);

        $totalRequests = $requestQuery->count();

        $matchedQuery = FoodRequest::query()->whereNotNull('matched_donation_id');
        $this->applyDateFilters($matchedQuery, $filters);
        $matched = $matchedQuery->count();

        $successRate = $totalRequests > 0 ? round(($matched / $totalRequests) * 100, 2) : 0;

        return [
            'total_requests' => $totalRequests,
            'matched' => $matched,
            'unmatched' => $totalRequests - $matched,
            'success_rate' => $successRate,
        ];
    }

    public function getDeliveryStats(array $filters = []): array
    {
        $query = DeliveryTask::query();
        $this->applyDateFilters($query, $filters);

        $total = $query->count();

        $byStatus = DeliveryTask::query();
        $this->applyDateFilters($byStatus, $filters);
        $byStatus = $byStatus->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $completedQuery = DeliveryTask::query()->where('status', 'delivered');
        $this->applyDateFilters($completedQuery, $filters);
        $completed = $completedQuery->count();

        $completionRate = $total > 0 ? round(($completed / $total) * 100, 2) : 0;

        return [
            'total' => $total,
            'by_status' => $byStatus,
            'completed' => $completed,
            'completion_rate' => $completionRate,
        ];
    }

    public function getFoodTypeDistribution(array $filters = []): Collection
    {
        $query = Donation::query();
        $this->applyDateFilters($query, $filters);

        return $query->select('food_type', DB::raw('count(*) as count'), DB::raw('sum(quantity) as total_quantity'))
            ->groupBy('food_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    public function getLocationStats(array $filters = []): Collection
    {
        $query = Donation::query();
        $this->applyDateFilters($query, $filters);

        return $query->select('location', DB::raw('count(*) as count'))
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->get();
    }

    protected function getUserStats(array $filters = []): array
    {
        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;

        $donorQuery = User::where('role', 'donor');
        $beneficiaryQuery = User::where('role', 'beneficiary');
        $volunteerQuery = User::where('role', 'volunteer');

        if ($startDate && $endDate) {
            $donorQuery->whereBetween('created_at', [$startDate, $endDate]);
            $beneficiaryQuery->whereBetween('created_at', [$startDate, $endDate]);
            $volunteerQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        return [
            'donors' => $donorQuery->count(),
            'beneficiaries' => $beneficiaryQuery->count(),
            'volunteers' => $volunteerQuery->count(),
            'total' => User::whereIn('role', ['donor', 'beneficiary', 'volunteer'])->count(),
        ];
    }

    protected function applyDateFilters($query, array $filters): void
    {
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        } elseif (isset($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        } elseif (isset($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }

        if (isset($filters['food_type'])) {
            if (method_exists($query->getModel(), 'food_type')) {
                $query->where('food_type', $filters['food_type']);
            }
        }

        if (isset($filters['location'])) {
            if (method_exists($query->getModel(), 'location')) {
                $query->where('location', $filters['location']);
            }
        }

        if (isset($filters['status'])) {
            if (method_exists($query->getModel(), 'status')) {
                $query->where('status', $filters['status']);
            }
        }
    }

    protected function formatDailyReportContent(array $data): string
    {
        return sprintf(
            "Daily Summary:\n\n" .
            "Donations: %d total (%d items)\n" .
            "Requests: %d total (%d matched, %.2f%% success rate)\n" .
            "Deliveries: %d total (%d completed, %.2f%% completion rate)\n\n" .
            "New Users: %d donors, %d beneficiaries, %d volunteers",
            $data['donations']['total'],
            $data['donations']['total_quantity'],
            $data['matching']['total_requests'],
            $data['matching']['matched'],
            $data['matching']['success_rate'],
            $data['delivery']['total'],
            $data['delivery']['completed'],
            $data['delivery']['completion_rate'],
            $data['users']['donors'],
            $data['users']['beneficiaries'],
            $data['users']['volunteers']
        );
    }

    protected function formatWeeklyReportContent(array $data, Carbon $startDate, Carbon $endDate): string
    {
        return sprintf(
            "Weekly Summary (%s to %s):\n\n" .
            "Donations: %d total (%d items)\n" .
            "Match Success Rate: %.2f%%\n" .
            "Delivery Completion Rate: %.2f%%\n" .
            "Total Food Saved: %d items\n\n" .
            "User Growth: +%d donors, +%d beneficiaries, +%d volunteers",
            $startDate->format('M d'),
            $endDate->format('M d, Y'),
            $data['donations']['total'],
            $data['donations']['total_quantity'],
            $data['matching']['success_rate'],
            $data['delivery']['completion_rate'],
            $data['donations']['total_quantity'],
            $data['users']['donors'],
            $data['users']['beneficiaries'],
            $data['users']['volunteers']
        );
    }

    protected function formatMonthlyReportContent(array $data, Carbon $month): string
    {
        return sprintf(
            "Monthly Report for %s:\n\n" .
            "Total Donations: %d (%d items saved from waste)\n" .
            "Match Success Rate: %.2f%%\n" .
            "Delivery Completion Rate: %.2f%%\n" .
            "Total Beneficiaries Served: %d\n\n" .
            "Impact Summary:\n" .
            "- Food Waste Reduced: %d items\n" .
            "- Active Users: %d total\n" .
            "- Platform Growth: +%d users this month",
            $month->format('F Y'),
            $data['donations']['total'],
            $data['donations']['total_quantity'],
            $data['matching']['success_rate'],
            $data['delivery']['completion_rate'],
            $data['users']['beneficiaries'],
            $data['donations']['total_quantity'],
            $data['users']['total'],
            $data['users']['donors'] + $data['users']['beneficiaries'] + $data['users']['volunteers']
        );
    }
}
