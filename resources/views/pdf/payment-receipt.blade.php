<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8px;
            color: #111;
            background: #fff;
            padding: 6px;
        }

        .header {
            text-align: center;
            border-bottom: 1.5px solid #1a2d5a;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: bold;
            color: #1a2d5a;
            letter-spacing: 1px;
        }

        .logo-text span {
            color: #6abf2e;
        }

        .title {
            font-size: 7px;
            color: #666;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section {
            margin-bottom: 5px;
            clear: both;
        }

        .section-title {
            font-size: 6px;
            font-weight: bold;
            color: #1a2d5a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 2px;
        }

        .row {
            display: block;
            margin-bottom: 2px;
            clear: both;
            overflow: hidden;
        }

        .label {
            float: left;
            color: #6b7280;
            font-size: 7px;
            text-align: left;
            width: 45%;
        }

        .value {
            float: right;
            font-weight: bold;
            font-size: 7px;
            text-align: right;
            width: 50%;
        }

        .tracking {
            text-align: center;
            background: #1a2d5a;
            color: #fff;
            padding: 4px;
            border-radius: 3px;
            margin: 5px 0;
            clear: both;
        }

        .tracking p {
            font-size: 6px;
            color: #9ca3af;
            margin-bottom: 1px;
        }

        .tracking span {
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
        }

        .total-row {
            display: block;
            background: #f0fdf4;
            padding: 4px 5px;
            border-radius: 3px;
            margin-top: 4px;
            clear: both;
            overflow: hidden;
        }

        .total-label {
            float: left;
            font-size: 7px;
            font-weight: bold;
            color: #1a2d5a;
            line-height: 14px;
        }

        .total-value {
            float: right;
            font-size: 10px;
            font-weight: bold;
            color: #6abf2e;
            line-height: 14px;
        }

        .paid-badge {
            text-align: center;
            background: #6abf2e;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
            padding: 5px;
            border-radius: 3px;
            margin: 6px 0;
            letter-spacing: 1px;
            clear: both;
        }

        .footer {
            text-align: center;
            margin-top: 6px;
            border-top: 1px dashed #d1d5db;
            padding-top: 5px;
            font-size: 6px;
            color: #9ca3af;
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            margin-top: 3px;
        }

        table th {
            background: #f9fafb;
            text-align: left;
            padding: 2px 3px;
            font-size: 6px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            padding: 2px 3px;
            border-bottom: 1px solid #f3f4f6;
        }
    </style>
</head>

<body>
    <div class="header">
        @if (!empty($logoBase64))
            <img src="data:image/png;base64,{{ $logoBase64 }}" style="height: 20px; margin-bottom: 2px;" alt="Trivo">
        @else
            <div class="logo-text">TRI<span>VO</span></div>
        @endif
        <div class="title">Bukti Pembayaran</div>
    </div>

    <div class="tracking">
        <p>Nomor Resi</p>
        <span>{{ $shipment->tracking_number }}</span>
    </div>

    <div class="section">
        <div class="section-title">Informasi Pembayaran</div>
        <div class="row">
            <span class="label">Tanggal</span>
            <span
                class="value">{{ $shipment->payment?->payment_date ? \Carbon\Carbon::parse($shipment->payment->payment_date)->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span class="label">Metode</span>
            <span
                class="value">{{ strtoupper(str_replace('_', ' ', $shipment->payment?->payment_method ?? 'Cash')) }}</span>
        </div>
        <div class="row">
            <span class="label">Dibayar oleh</span>
            <span class="value">{{ $shipment->payer_type === 'receiver' ? 'Penerima (COD)' : 'Pengirim' }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detail Pengiriman</div>
        <div class="row">
            <span class="label">Pengirim</span>
            <span class="value">{{ $shipment->sender?->name }}</span>
        </div>
        <div class="row">
            <span class="label">Penerima</span>
            <span class="value">{{ $shipment->receiver?->name }}</span>
        </div>
        <div class="row">
            <span class="label">Dari</span>
            <span class="value">{{ $shipment->originBranch?->city }}</span>
        </div>
        <div class="row">
            <span class="label">Tujuan</span>
            <span class="value">{{ $shipment->destinationBranch?->city }}</span>
        </div>
        <div class="row">
            <span class="label">Total Berat</span>
            <span class="value">{{ number_format($shipment->total_weight, 2) }} kg</span>
        </div>
    </div>

    @if ($shipment->items->isNotEmpty())
        <div class="section">
            <div class="section-title">Item</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th style="width: 30px;">Qty</th>
                        <th style="text-align:right; width: 40px;">Berat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipment->items as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align:right">{{ number_format($item->weight, 2) }}kg</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="total-row">
        <span class="total-label">TOTAL BIAYA</span>
        <span class="total-value">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
    </div>

    <div class="paid-badge">✓ LUNAS</div>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan Trivo.</p>
        <p>Simpan struk ini sebagai bukti pembayaran Anda.</p>
    </div>
</body>

</html>
