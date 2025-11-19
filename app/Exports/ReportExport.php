<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ReportExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected array $data;
    protected string $reportTitle;

    public function __construct(array $data, string $reportTitle = 'Report')
    {
        $this->data = $data;
        $this->reportTitle = $reportTitle;
    }

    public function collection()
    {
        $rows = new Collection();

        // Summary section
        $rows->push(['SUMMARY', '', '', '']);
        $rows->push(['Total Donations', $this->data['donations']['total'] ?? 0, '', '']);
        $rows->push(['Total Quantity', $this->data['donations']['total_quantity'] ?? 0, 'items', '']);
        $rows->push(['Total Requests', $this->data['matching']['total_requests'] ?? 0, '', '']);
        $rows->push(['Matched Requests', $this->data['matching']['matched'] ?? 0, '', '']);
        $rows->push(['Match Success Rate', ($this->data['matching']['success_rate'] ?? 0) . '%', '', '']);
        $rows->push(['Total Deliveries', $this->data['delivery']['total'] ?? 0, '', '']);
        $rows->push(['Completed Deliveries', $this->data['delivery']['completed'] ?? 0, '', '']);
        $rows->push(['Delivery Completion Rate', ($this->data['delivery']['completion_rate'] ?? 0) . '%', '', '']);
        $rows->push(['']);

        // Donations by Status
        $rows->push(['DONATIONS BY STATUS', '', '', '']);
        $rows->push(['Status', 'Count', '', '']);
        foreach (($this->data['donations']['by_status'] ?? []) as $status => $count) {
            $rows->push([ucfirst($status), $count, '', '']);
        }
        $rows->push(['']);

        // Deliveries by Status
        $rows->push(['DELIVERIES BY STATUS', '', '', '']);
        $rows->push(['Status', 'Count', '', '']);
        foreach (($this->data['delivery']['by_status'] ?? []) as $status => $count) {
            $rows->push([ucfirst($status), $count, '', '']);
        }
        $rows->push(['']);

        // Food Types Distribution
        $rows->push(['FOOD TYPES DISTRIBUTION', '', '', '']);
        $rows->push(['Food Type', 'Count', 'Total Quantity', '']);
        foreach (($this->data['food_types'] ?? []) as $foodType) {
            $rows->push([
                $foodType['food_type'] ?? 'Unknown',
                $foodType['count'] ?? 0,
                $foodType['total_quantity'] ?? 0,
                ''
            ]);
        }
        $rows->push(['']);

        // Locations
        $rows->push(['DONATIONS BY LOCATION', '', '', '']);
        $rows->push(['Location', 'Count', '', '']);
        foreach (($this->data['locations'] ?? []) as $location) {
            $rows->push([
                $location['location'] ?? 'Unknown',
                $location['count'] ?? 0,
                '',
                ''
            ]);
        }
        $rows->push(['']);

        // Users
        $rows->push(['USER STATISTICS', '', '', '']);
        $rows->push(['Donors', $this->data['users']['donors'] ?? 0, '', '']);
        $rows->push(['Beneficiaries', $this->data['users']['beneficiaries'] ?? 0, '', '']);
        $rows->push(['Volunteers', $this->data['users']['volunteers'] ?? 0, '', '']);
        $rows->push(['Total Users', $this->data['users']['total'] ?? 0, '', '']);

        return $rows;
    }

    public function headings(): array
    {
        return [
            $this->reportTitle,
            'Generated: ' . now()->format('Y-m-d H:i:s'),
            '',
            ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            'A:A' => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Analytics Report';
    }
}
