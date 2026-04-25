<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengiriman Trivo</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size:11px; color:#222; padding:24px; }
        .header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:3px solid #1a2b5c; padding-bottom:14px; margin-bottom:18px; }
        .brand h1 { font-size:22px; font-weight:900; color:#1a2b5c; letter-spacing:2px; }
        .brand p { font-size:9px; color:#6b7280; margin-top:2px; }
        .report-info { text-align:right; }
        .report-info h2 { font-size:14px; font-weight:800; color:#1a2b5c; text-transform:uppercase; }
        .report-info p { font-size:10px; color:#6b7280; margin-top:2px; }
        .stats { display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; margin-bottom:18px; }
        .stat-box { border:1px solid #e5e7eb; border-radius:8px; padding:10px; text-align:center; }
        .stat-box .num { font-size:20px; font-weight:800; color:#1a2b5c; }
        .stat-box .lbl { font-size:9px; color:#6b7280; margin-top:2px; text-transform:uppercase; }
        table { width:100%; border-collapse:collapse; }
        thead th { background:#1a2b5c; color:white; padding:7px 8px; text-align:left; font-size:9px; font-weight:700; text-transform:uppercase; }
        tbody td { padding:6px 8px; border-bottom:1px solid #f3f4f6; font-size:10px; }
        tbody tr:nth-child(even) { background:#f9fafb; }
        .status-badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:9px; font-weight:700; }
        .status-delivered { background:#d1fae5; color:#065f46; }
        .status-pending { background:#fef3c7; color:#92400e; }
        .status-cancelled { background:#fee2e2; color:#991b1b; }
        .status-other { background:#e0e7ff; color:#3730a3; }
        .footer { margin-top:20px; border-top:1px solid #e5e7eb; padding-top:12px; display:flex; justify-content:space-between; font-size:9px; color:#9ca3af; }
    </style>
</head>
<body>

<div class="header">
    <div class="brand">
        <h1>TRIVO</h1>
        <p>Solusi Pengiriman Terpercaya</p>
        <p>Laporan dihasilkan: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }}</p>
    </div>
    <div class="report-info">
        <h2>Laporan Pengiriman</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }} — {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}</p>
        @if($status)<p>Status Filter: {{ ucfirst($status) }}</p>@endif
        <p>Total data: <strong>{{ $shipments->count() }} pengiriman</strong></p>
    </div>
</div>

<div class="stats">
    <div class="stat-box">
        <div class="num">{{ $shipments->count() }}</div>
        <div class="lbl">Total</div>
    </div>
    <div class="stat-box">
        <div class="num" style="color:#065f46">{{ $shipments->where('status','delivered')->count() }}</div>
        <div class="lbl">Terkirim</div>
    </div>
    <div class="stat-box">
        <div class="num" style="color:#92400e">{{ $shipments->whereIn('status',['pending','in_transit','out_for_delivery'])->count() }}</div>
        <div class="lbl">Proses</div>
    </div>
    <div class="stat-box">
        <div class="num" style="color:#6abf2e">Rp {{ number_format($shipments->sum('total_price')/1000000, 1) }}jt</div>
        <div class="lbl">Total Nilai</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>No. Resi</th>
            <th>Tgl Kirim</th>
            <th>Pengirim</th>
            <th>Penerima</th>
            <th>Rute</th>
            <th>Berat</th>
            <th>Biaya</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shipments as $i => $shipment)
        @php
        $statusClass = match($shipment->status) {
            'delivered' => 'status-delivered',
            'pending'   => 'status-pending',
            'cancelled' => 'status-cancelled',
            default     => 'status-other',
        };
        $statusLabel = [
            'pending'=>'Menunggu','picked_up'=>'Diambil','in_transit'=>'Transit',
            'arrived_at_branch'=>'Di Cabang','out_for_delivery'=>'Diantar',
            'delivered'=>'Terkirim','cancelled'=>'Batal',
        ][$shipment->status] ?? $shipment->status;
        @endphp
        <tr>
            <td>{{ $i+1 }}</td>
            <td style="font-family:monospace;font-weight:600">{{ $shipment->tracking_number }}</td>
            <td>{{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->format('d/m/Y') : '-' }}</td>
            <td>{{ $shipment->sender?->name }}</td>
            <td>{{ $shipment->receiver?->name }}</td>
            <td>{{ $shipment->originBranch?->city }} → {{ $shipment->destinationBranch?->city }}</td>
            <td>{{ $shipment->total_weight }} kg</td>
            <td>Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td>
            <td><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <span>Trivo — Solusi Pengiriman Terpercaya</span>
    <span>Halaman 1 | Dibuat oleh: {{ Auth::user()?->name }}</span>
</div>

</body>
</html>
