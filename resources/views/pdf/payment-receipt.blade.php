<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran - {{ $shipment->tracking_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            line-height: 1.3;
            color: #1e1e2f;
        }
        @page {
            size: A4;
            margin: 0.6cm;
        }
        .receipt {
            width: 100%;
            background: white;
        }
        .header {
            background-color: #1a2d5a;
            color: white;
            padding: 5px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-text {
            font-size: 16pt;
            font-weight: bold;
        }
        .logo-text span { color: #6abf2e; }
        .resi-label {
            font-size: 6.5pt;
            text-transform: uppercase;
            opacity: 0.8;
        }
        .resi-number {
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .paid-badge {
            background-color: #10b981;
            padding: 1px 6px;
            border-radius: 12px;
            font-size: 7pt;
            font-weight: bold;
            display: inline-block;
            margin-top: 2px;
        }
        .body {
            padding: 6px 10px;
        }
        .section-title {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a2d5a;
            border-bottom: 1px solid #6abf2e;
            padding-bottom: 2px;
            margin: 6px 0 4px 0;
        }
        .route-box {
            background: #f5f7fc;
            border: 1px solid #dce3ec;
            border-radius: 4px;
            padding: 5px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .city {
            font-size: 10pt;
            font-weight: bold;
            color: #1a2d5a;
        }
        .branch-name {
            font-size: 7pt;
            color: #2c3e66;
        }
        .branch-address {
            font-size: 6.5pt;
            color: #4a5568;
        }
        .arrow {
            font-size: 14pt;
            font-weight: bold;
            color: #6abf2e;
        }
        .info-bar {
            display: flex;
            justify-content: space-between;
            background: #f0f4fa;
            padding: 3px 8px;
            border-radius: 3px;
            margin-bottom: 6px;
            font-size: 6.5pt;
        }
        /* Dua kolom bersebelahan secara permanen */
        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 8px;
        }
        .col-box {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 5px 6px;
            background: #fefefe;
        }
        .col-title {
            font-size: 7.5pt;
            font-weight: bold;
            color: #1a2d5a;
            border-bottom: 1px solid #cbd5e1;
            margin-bottom: 4px;
            padding-bottom: 1px;
            text-transform: uppercase;
        }
        .info-row {
            margin-bottom: 3px;
            display: flex;
            align-items: baseline;
        }
        .info-label {
            font-size: 6.5pt;
            color: #4a5568;
            width: 48px;
            flex-shrink: 0;
        }
        .info-value {
            font-size: 7.5pt;
            font-weight: 600;
            color: #1a2d5a;
            word-break: break-word;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
        }
        .items-table th {
            background: #eef2f7;
            text-align: left;
            padding: 3px 5px;
            font-size: 6.5pt;
            border: 1px solid #d0dae8;
        }
        .items-table td {
            padding: 3px 5px;
            border: 1px solid #d0dae8;
            font-size: 7pt;
        }
        .total-box {
            margin-top: 4px;
            text-align: right;
        }
        .total-table {
            width: auto;
            margin-left: auto;
            border-collapse: collapse;
        }
        .total-table td {
            padding: 2px 6px;
        }
        .total-label {
            font-weight: bold;
            font-size: 7.5pt;
        }
        .total-amount {
            font-size: 10pt;
            font-weight: bold;
            color: #16a34a;
        }
        .total-row-bg {
            background: #eafaf1;
        }
        .footer {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 6.5pt;
        }
        .sign-line {
            width: 100px;
            border-bottom: 1px solid #1e1e2f;
            margin-bottom: 3px;
            height: 20px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .col-box {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="header">
        <div class="logo-text">TRI<span>VO</span></div>
        <div class="resi-area">
            <div class="resi-label">Nomor Resi</div>
            <div class="resi-number">{{ $shipment->tracking_number }}</div>
            <div class="paid-badge">LUNAS</div>
        </div>
    </div>
    <div class="body">
        <div class="section-title">Detail Pengiriman</div>
        <div class="route-box">
            <div>
                <div class="city">{{ $shipment->originBranch?->city ?? '-' }}</div>
                <div class="branch-name">{{ $shipment->originBranch?->name ?? '-' }}</div>
                <div class="branch-address">{{ $shipment->originBranch?->address ?? '' }}</div>
            </div>
            <div class="arrow">→</div>
            <div>
                <div class="city">{{ $shipment->destinationBranch?->city ?? '-' }}</div>
                <div class="branch-name">{{ $shipment->destinationBranch?->name ?? '-' }}</div>
                <div class="branch-address">{{ $shipment->destinationBranch?->address ?? '' }}</div>
            </div>
        </div>
        <div class="info-bar">
            <span><strong>Tanggal Kirim:</strong> {{ \Carbon\Carbon::parse($shipment->shipment_date)->isoFormat('D MMM Y') }}</span>
            <span><strong>Kurir:</strong> {{ $shipment->courier?->name ?? '-' }}</span>
            <span><strong>Pembayaran:</strong> {{ $shipment->payer_type === 'receiver' ? 'COD' : 'Prepaid' }}</span>
        </div>

        <div class="section-title">Pengirim & Penerima</div>
        <div class="two-cols">
            <div class="col-box">
                <div class="col-title">Pengirim</div>
                <div class="info-row"><span class="info-label">Nama :</span><span class="info-value">{{ $shipment->sender?->name ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Telepon :</span><span class="info-value">{{ $shipment->sender?->phone ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Alamat :</span><span class="info-value">{{ $shipment->sender?->address ?? '-' }}</span></div>
            </div>
            <div class="col-box">
                <div class="col-title">Penerima</div>
                <div class="info-row"><span class="info-label">Nama :</span><span class="info-value">{{ $shipment->receiver?->name ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Telepon :</span><span class="info-value">{{ $shipment->receiver?->phone ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Alamat :</span><span class="info-value">{{ $shipment->receiver?->address ?? '-' }}</span></div>
            </div>
        </div>

        <div class="section-title">Item Kiriman</div>
        <table class="items-table">
            <thead><tr><th>Nama Barang</th><th style="width:50px">Qty</th><th style="width:70px">Berat (kg)</th></tr></thead>
            <tbody>
                @forelse ($shipment->items as $item)
                <tr><td>{{ $item->item_name ?? $item->name ?? '-' }}</td><td>{{ $item->quantity }}</td><td>{{ number_format($item->weight, 2) }}</td></tr>
                @empty
                <tr><td colspan="3">Tidak ada item</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-box">
            <table class="total-table">
                <tr><td class="total-label">Total Berat:</td><td>{{ number_format($shipment->total_weight, 2) }} kg</td></tr>
                <tr><td class="total-label">Ongkos Kirim:</td><td>Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td></tr>
                <tr class="total-row-bg"><td class="total-label" style="font-size:9pt;">TOTAL:</td><td class="total-amount">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</td></tr>
            </table>
        </div>

        <div class="footer">
            <div>Dicetak: {{ now()->isoFormat('D MMM Y, HH:mm') }}<br>Simpan sebagai bukti sah.</div>
            <div style="text-align:center">
                <div class="sign-line"></div>
                <div>Petugas Kasir</div>
                <div>{{ $cashierName ?? Auth::user()?->name ?? 'Trivo' }}</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>