<?php

namespace App\Contracts\Services;

use App\Models\Report;
use Illuminate\Support\Collection;

interface ReportServiceInterface
{
    public function generate(int $adminId, string $title, string $content): Report;

    public function listByAdmin(int $adminId, int $perPage = 15);

    public function generateDailyReport(int $adminId, ?\DateTime $date = null): Report;

    public function generateWeeklyReport(int $adminId, ?\DateTime $startDate = null): Report;

    public function generateMonthlyReport(int $adminId, ?\DateTime $month = null): Report;

    public function getAnalyticsData(array $filters = []): array;

    public function getDonationStats(array $filters = []): array;

    public function getMatchingStats(array $filters = []): array;

    public function getDeliveryStats(array $filters = []): array;

    public function getFoodTypeDistribution(array $filters = []): Collection;

    public function getLocationStats(array $filters = []): Collection;
}


