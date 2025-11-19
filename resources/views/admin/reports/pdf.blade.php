<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #1f2937;
            margin: 0 0 5px 0;
        }
        .header p {
            color: #6b7280;
            margin: 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .summary-row {
            display: table-row;
        }
        .summary-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #e5e7eb;
            width: 50%;
        }
        .summary-cell strong {
            color: #1f2937;
        }
        .stat-box {
            background: #f9fafb;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #2563eb;
        }
        .stat-box h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #1f2937;
        }
        .stat-box p {
            margin: 5px 0;
            color: #4b5563;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e5e7eb;
        }
        td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FoodBridge Analytics Report</h1>
        <p>Generated on {{ $generatedAt->format('F d, Y \a\t H:i:s') }}</p>
        @if(isset($filters['start_date']) && isset($filters['end_date']))
            <p>Period: {{ $filters['start_date']->format('M d, Y') }} - {{ $filters['end_date']->format('M d, Y') }}</p>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="section">
        <div class="section-title">Executive Summary</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <strong>Total Donations:</strong> {{ $data['donations']['total'] }}
                </div>
                <div class="summary-cell">
                    <strong>Total Items:</strong> {{ $data['donations']['total_quantity'] }}
                </div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">
                    <strong>Total Requests:</strong> {{ $data['matching']['total_requests'] }}
                </div>
                <div class="summary-cell">
                    <strong>Matched Requests:</strong> {{ $data['matching']['matched'] }}
                </div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">
                    <strong>Match Success Rate:</strong> {{ $data['matching']['success_rate'] }}%
                </div>
                <div class="summary-cell">
                    <strong>Delivery Completion Rate:</strong> {{ $data['delivery']['completion_rate'] }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Donations Section -->
    <div class="section">
        <div class="section-title">Donations Overview</div>
        <p><strong>Total Donations:</strong> {{ $data['donations']['total'] }}</p>
        <p><strong>Total Quantity:</strong> {{ $data['donations']['total_quantity'] }} items</p>

        <h3 style="margin-top: 15px;">Donations by Status</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['donations']['by_status'] as $status => $count)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Matching Section -->
    <div class="section">
        <div class="section-title">Matching Performance</div>
        <div class="stat-box">
            <h3>Success Rate</h3>
            <p class="stat-value">{{ $data['matching']['success_rate'] }}%</p>
            <p>{{ $data['matching']['matched'] }} matched out of {{ $data['matching']['total_requests'] }} requests</p>
        </div>
    </div>

    <!-- Delivery Section -->
    <div class="section">
        <div class="section-title">Delivery Statistics</div>
        <p><strong>Total Deliveries:</strong> {{ $data['delivery']['total'] }}</p>
        <p><strong>Completed Deliveries:</strong> {{ $data['delivery']['completed'] }}</p>
        <p><strong>Completion Rate:</strong> {{ $data['delivery']['completion_rate'] }}%</p>

        <h3 style="margin-top: 15px;">Deliveries by Status</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['delivery']['by_status'] as $status => $count)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Food Types Section -->
    <div class="section">
        <div class="section-title">Food Types Distribution</div>
        <table>
            <thead>
                <tr>
                    <th>Food Type</th>
                    <th>Count</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['food_types'] as $foodType)
                <tr>
                    <td>{{ $foodType['food_type'] }}</td>
                    <td>{{ $foodType['count'] }}</td>
                    <td>{{ $foodType['total_quantity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Locations Section -->
    <div class="section">
        <div class="section-title">Donations by Location</div>
        <table>
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['locations'] as $location)
                <tr>
                    <td>{{ $location['location'] }}</td>
                    <td>{{ $location['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Users Section -->
    <div class="section">
        <div class="section-title">User Statistics</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <strong>Donors:</strong> {{ $data['users']['donors'] }}
                </div>
                <div class="summary-cell">
                    <strong>Beneficiaries:</strong> {{ $data['users']['beneficiaries'] }}
                </div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">
                    <strong>Volunteers:</strong> {{ $data['users']['volunteers'] }}
                </div>
                <div class="summary-cell">
                    <strong>Total Active Users:</strong> {{ $data['users']['total'] }}
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>FoodBridge - Reducing Food Waste in Al-Jouf | © {{ date('Y') }}</p>
        <p>This is an automated report generated by the FoodBridge platform</p>
    </div>
</body>
</html>
