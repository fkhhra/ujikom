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
            font-size: 9px;
            color: #111;
            padding: 10px;
        }

        .waybill {
            border: 2px solid #1a2d5a;
            border-radius: 5px;
            overflow: hidden;
            background: #fff;
        }

        .logo-text {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
        }

        .logo-text span {
            color: #6abf2e;
        }

        .sub-label {
            font-size: 7px;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .tracking-num {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #fff;
        }

        .body {
            padding: 10px 12px;
        }

        .section-title {
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6abf2e;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .party-name {
            font-size: 11px;
            font-weight: bold;
            color: #1a2d5a;
            margin-bottom: 2px;
        }

        .party-info {
            font-size: 8px;
            color: #4b5563;
            margin-bottom: 1px;
        }

        .city {
            font-size: 12px;
            font-weight: bold;
            color: #1a2d5a;
        }

        .arrow {
            font-size: 14px;
            color: #6abf2e;
        }

        .branch-name {
            font-size: 7px;
            color: #9ca3af;
        }

        .items-section {
            margin-top: 8px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-top: 5px;
        }

        .items-table th {
            background: #f9fafb;
            padding: 3px 5px;
            text-align: left;
            font-size: 7px;
            color: #6b7280;
            text-transform: uppercase;
            border: 1px solid #e5e7eb;
            font-weight: bold;
        }

        .items-table td {
            padding: 3px 5px;
            border: 1px solid #e5e7eb;
        }

        .totals-box {
            background: #1a2d5a;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
        }

        .total-label {
            font-size: 7px;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .total-val {
            font-size: 13px;
            font-weight: bold;
            color: #6abf2e;
        }

        .sig-box {
            border: 1px solid #e5e7eb;
            width: 110px;
            height: 45px;
            border-radius: 3px;
            position: relative;
            margin: 0 auto;
        }

        .sig-label {
            font-size: 7px;
            color: #9ca3af;
            position: absolute;
            bottom: 3px;
            left: 5px;
            text-align: left;
        }

        .payer-badge {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 2px 6px;
            border-radius: 99px;
            font-size: 7px;
            font-weight: bold;
            display: inline-block;
        }

        .cod-badge {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a3412;
            padding: 2px 6px;
            border-radius: 99px;
            font-size: 7px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="waybill">
        <!-- Header Table -->
        <table
            style="width: 100%; background: #1a2d5a; color: white; border-collapse: collapse; border: none; margin: 0; padding: 0;">
            <tr>
                <td style="padding: 8px 12px; vertical-align: middle; border: none; text-align: left;">
                    @if (!empty($logoBase64))
                        <img src="data:image/png;base64,{{ $logoBase64 }}" style="height: 24px; display: block;"
                            alt="Trivo">
                    @else
                        <div class="logo-text">TRI<span>VO</span></div>
                    @endif
                </td>
                <td style="padding: 8px 12px; text-align: right; vertical-align: middle; border: none;">
                    <div class="sub-label">Nomor Resi / Waybill</div>
                    <div class="tracking-num">{{ $shipment->tracking_number }}</div>
                    <div class="sub-label">{{ $shipment->shipment_date?->format('d M Y') }}</div>
                </td>
            </tr>
        </table>

        <div class="body">
            <!-- Route Table -->
            <table
                style="width: 100%; background: #f8fafc; border: 1px solid #e5e7eb; border-collapse: collapse; border-radius: 4px; margin-bottom: 8px;">
                <tr>
                    <td style="padding: 6px 10px; text-align: left; vertical-align: middle; border: none;">
                        <div class="city">{{ $shipment->originBranch?->city }}</div>
                        <div class="branch-name">{{ $shipment->originBranch?->name }}</div>
                    </td>
                    <td
                        style="padding: 6px 10px; text-align: center; vertical-align: middle; border: none; font-size: 14px; color: #6abf2e; font-family: 'DejaVu Sans', sans-serif;">
                        →
                    </td>
                    <td style="padding: 6px 10px; text-align: right; vertical-align: middle; border: none;">
                        <div class="city">{{ $shipment->destinationBranch?->city }}</div>
                        <div class="branch-name">{{ $shipment->destinationBranch?->name }}</div>
                    </td>
                    <td
                        style="padding: 6px 10px; text-align: right; vertical-align: middle; border: none; width: 80px;">
                        @if ($shipment->payer_type === 'receiver')
                            <span class="cod-badge">COD</span>
                        @else
                            <span class="payer-badge">PREPAID</span>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Sender & Receiver Table -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 8px;">
                <tr>
                    <td
                        style="width: 50%; border: none; border-right: 1px solid #e5e7eb; padding-right: 8px; vertical-align: top; text-align: left;">
                        <div class="section-title">Pengirim</div>
                        <div class="party-name">{{ $shipment->sender?->name }}</div>
                        <div class="party-info">{{ $shipment->sender?->phone }}</div>
                        <div class="party-info">{{ $shipment->sender?->address }}</div>
                    </td>
                    <td style="width: 50%; border: none; padding-left: 8px; vertical-align: top; text-align: left;">
                        <div class="section-title">Penerima</div>
                        <div class="party-name">{{ $shipment->receiver?->name }}</div>
                        <div class="party-info">{{ $shipment->receiver?->phone }}</div>
                        <div class="party-info">{{ $shipment->receiver?->address }}</div>
                    </td>
                </tr>
            </table>

            <!-- Items Table -->
            <div class="items-section">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th style="width: 60px;">Qty</th>
                            <th style="width: 80px;">Berat (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipment->items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->weight, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals Table -->
            <table style="width: 100%; border-collapse: collapse; margin-top: 6px;">
                <tr>
                    <td style="border: none;"></td>
                    <td style="width: 250px; border: none; text-align: right;">
                        <div class="totals-box">
                            <div class="total-label">TOTAL BERAT / BIAYA</div>
                            <div class="total-val">{{ number_format($shipment->total_weight, 2) }} kg · Rp
                                {{ number_format($shipment->total_price, 0, ',', '.') }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #d1d5db;">
                <tr>
                    <td style="width: 70%; border: none; vertical-align: middle; text-align: left; padding: 5px 0;">
                        @if (isset($barcode))
                            <img src="data:image/png;base64,{{ $barcode }}" height="38" style="display: block; margin-bottom: 3px;" alt="{{ $shipment->tracking_number }}">
                            <span style="font-size: 7.5px; color: #4b5563; font-family: monospace; letter-spacing: 1px; padding-left: 2px;">{{ $shipment->tracking_number }}</span>
                        @else
                            <p style="font-size: 8px; color: #9ca3af;">{{ $shipment->tracking_number }}</p>
                        @endif
                    </td>
                    <td style="width: 30%; border: none; vertical-align: middle; text-align: right; padding: 5px 0;">
                        @if (isset($qrcode))
                            <img src="data:image/svg+xml;base64,{{ $qrcode }}" height="42" alt="QR Code">
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
