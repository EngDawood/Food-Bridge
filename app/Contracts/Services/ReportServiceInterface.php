<?php

namespace App\Contracts\Services;

use App\Models\Report;

interface ReportServiceInterface
{
    public function generate(int $adminId, string $title, string $content): Report;

    public function listByAdmin(int $adminId, int $perPage = 15);
}


