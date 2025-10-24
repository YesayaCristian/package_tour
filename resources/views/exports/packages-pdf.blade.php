<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Paket Wisata - TourTravels</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #3B82F6;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #3B82F6;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header .subtitle {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .header .date {
            color: #888;
            font-size: 11px;
        }
        .summary {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #3B82F6;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            text-align: center;
        }
        .summary-item {
            padding: 10px;
        }
        .summary-number {
            font-size: 20px;
            font-weight: bold;
            color: #3B82F6;
            display: block;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .filters-info {
            background: #f1f5f9;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 10px;
            border: 1px solid #e2e8f0;
        }
        .filters-info strong {
            color: #3B82F6;
        }
        .filter-item {
            margin-bottom: 3px;
            padding: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
            page-break-inside: auto;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        th {
            background-color: #3B82F6;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2563eb;
            font-size: 8px;
        }
        td {
            padding: 6px;
            border: 1px solid #e2e8f0;
            font-size: 8px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .status-badge {
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 60px;
        }
        .status-available {
            background-color: #10B981;
            color: white;
        }
        .status-full {
            background-color: #EF4444;
            color: white;
        }
        .status-inactive {
            background-color: #6B7280;
            color: white;
        }
        .price {
            font-weight: bold;
            color: #059669;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 9px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PAKET WISATA</h1>
        <div class="subtitle">TourTravels - Platform Wisata Terpercaya</div>
        <div class="date">Dibuat pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</div>
    </div>

    @if(!empty($filters['search']) || !empty($filters['status']) || !empty($filters['location']))
    <div class="filters-info">
        <strong>FILTER YANG DITERAPKAN:</strong>
        <div class="filter-item">
            @if(!empty($filters['search']))
            • Pencarian: "<strong>{{ $filters['search'] }}</strong>"
            @endif
        </div>
        <div class="filter-item">
            @if(!empty($filters['status']))
            • Status: <strong>{{ ucfirst($filters['status']) }}</strong>
            @endif
        </div>
        <div class="filter-item">
            @if(!empty($filters['location']))
            • Lokasi: <strong>{{ $filters['location'] }}</strong>
            @endif
        </div>
    </div>
    @endif

    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-number">{{ $totalPackages }}</span>
                <span class="summary-label">Total Paket</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $packages->where('status', 'available')->count() }}</span>
                <span class="summary-label">Paket Tersedia</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $packages->where('status', 'full')->count() }}</span>
                <span class="summary-label">Paket Penuh</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                <span class="summary-label">Total Potensi Pendapatan</span>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">NO</th>
                <th width="22%">NAMA PAKET</th>
                <th width="12%">LOKASI</th>
                <th width="10%">DURASI</th>
                <th width="12%">HARGA</th>
                <th width="8%">KURSI</th>
                <th width="10%">TGL MULAI</th>
                <th width="10%">TGL SELESAI</th>
                <th width="8%">STATUS</th>
                <th width="14%">DESKRIPSI SINGKAT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $index => $package)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $package->title }}</strong></td>
                <td>{{ $package->location }}</td>
                <td class="text-center">{{ $package->duration }}</td>
                <td class="text-right price">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $package->available_seats }}</td>
                <td class="text-center">{{ $package->start_date->format('d/m/Y') }}</td>
                <td class="text-center">{{ $package->end_date->format('d/m/Y') }}</td>
                <td class="text-center">
                    @if($package->status === 'available')
                        <span class="status-badge status-available">TERSEDIA</span>
                    @elseif($package->status === 'full')
                        <span class="status-badge status-full">PENUH</span>
                    @else
                        <span class="status-badge status-inactive">NON-AKTIF</span>
                    @endif
                </td>
                <td>{{ Str::limit(strip_tags($package->description), 80) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="no-data">
                    <div style="padding: 20px;">
                        <div style="font-size: 36px; color: #d1d5db; margin-bottom: 8px;">📭</div>
                        <div style="font-size: 12px; color: #6b7280;">Tidak ada data paket wisata</div>
                        <div style="font-size: 10px; color: #9ca3af; margin-top: 4px;">Data akan muncul ketika paket wisata ditambahkan</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($packages->count() > 0)
    <div style="margin-top: 15px; padding: 12px; background: #f0f9ff; border-radius: 6px; border-left: 4px solid #0ea5e9;">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 10px;">
            <div>
                <strong>Ringkasan Laporan:</strong>
            </div>
            <div style="text-align: right;">
                <strong>Total Data: {{ $packages->count() }} paket</strong>
            </div>
            <div>
                <strong>Total Potensi Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
            </div>
            <div style="text-align: right;">
                <strong>Rata-rata Harga: Rp {{ number_format($packages->avg('price'), 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>
    @endif

    <div class="footer">
        <div style="margin-bottom: 4px;">Dokumen ini dibuat secara otomatis oleh Sistem Manajemen TourTravels</div>
        <div style="color: #9ca3af;">© {{ date('Y') }} PT. TourTravels Indonesia. All rights reserved.</div>
        <div style="margin-top: 4px; font-size: 8px; color: #9ca3af;">Halaman <span class="page-number"></span></div>
    </div>
</body>
</html>