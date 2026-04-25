<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi {{ $payment->shipment?->tracking_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; background: #fff; padding: 30px; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid #1a2b5c; padding-bottom: 16px; margin-bottom: 20px; }
        .logo-area img { height: 48px; }
        .logo-area { display: flex; align-items: center; gap: 12px; }
        .logo-text h1 { font-size: 20px; font-weight: 800; color: #1a2b5c; letter-spacing: 2px; }
        .logo-text p { font-size: 10px; color: #6b7280; }
        .receipt-title { text-align: right; }
        .receipt-title h2 { font-size: 18px; font-weight: 700; color: #1a2b5c; text-transform: uppercase; }
        .receipt-title p { font-size: 11px; color: #6b7280; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #d1fae5; color: #065f46; }
        .badge.unpaid { background: #fee2e2; color: #991b1b; }
        .badge.pending { background: #fef3c7; color: #92400e; }

        .section { margin-bottom: 16px; }
        .section-title { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; }

        .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .info-block p.label { font-size: 10px; color: #9ca3af; margin-bottom: 2px; }
        .info-block p.value { font-size: 12px; font-weight: 600; color: #111; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        thead th { background: #1a2b5c; color: white; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f9fafb; }

        .total-row { background: #f0f7e8 !important; border-top: 2px solid #6abf2e; }
        .total-row td { font-weight: 700; font-size: 13px; color: #1a2b5c; }
        .total-row .amount { color: #6abf2e; font-size: 16px; }

        .footer { margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 16px; display: flex; justify-content: space-between; align-items: flex-end; }
        .footer .note { font-size: 10px; color: #9ca3af; max-width: 300px; line-height: 1.5; }
        .footer .sign { text-align: center; }
        .footer .sign .sign-line { width: 140px; border-bottom: 1px solid #111; margin-bottom: 4px; height: 40px; }
        .footer .sign p { font-size: 10px; color: #6b7280; }

        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print" style="margin-bottom:16px; text-align:right;">
    <button onclick="window.print()" style="background:#1a2b5c;color:white;border:none;padding:8px 20px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">🖨️ Cetak Kwitansi</button>
</div>

<div class="header">
    <div class="logo-area">
        <img src="{{ public_path('images/branding/logo.png') }}" alt="Trivo">
        <div class="logo-text">
            <p>{{ $payment->shipment?->originBranch?->name }}</p>
            <p>{{ $payment->shipment?->originBranch?->address }}</p>
        </div>
    </div>
    <div class="receipt-title">
        <h2>Kwitansi Pembayaran</h2>
        <p>No. Resi: <strong>{{ $payment->shipment?->tracking_number }}</strong></p>
        <p>Tanggal: {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
        <span class="badge {{ $payment->payment_status !== 'paid' ? ($payment->payment_status === 'pending' ? 'pending' : 'unpaid') : '' }}">
            {{ $payment->payment_status === 'paid' ? '✓ LUNAS' : strtoupper($payment->payment_status ?? 'BELUM BAYAR') }}
        </span>
    </div>
</div>

<div class="grid2 section">
    <div>
        <div class="section-title">Pengirim</div>
        <div class="info-block">
            <p class="label">Nama</p>
            <p class="value">{{ $payment->shipment?->sender?->name }}</p>
        </div>
        <div class="info-block" style="margin-top:6px">
            <p class="label">Telepon</p>
            <p class="value">{{ $payment->shipment?->sender?->phone ?? '-' }}</p>
        </div>
        <div class="info-block" style="margin-top:6px">
            <p class="label">Cabang Asal</p>
            <p class="value">{{ $payment->shipment?->originBranch?->name }} — {{ $payment->shipment?->originBranch?->city }}</p>
        </div>
    </div>
    <div>
        <div class="section-title">Penerima</div>
        <div class="info-block">
            <p class="label">Nama</p>
            <p class="value">{{ $payment->shipment?->receiver?->name }}</p>
        </div>
        <div class="info-block" style="margin-top:6px">
            <p class="label">Telepon</p>
            <p class="value">{{ $payment->shipment?->receiver?->phone ?? '-' }}</p>
        </div>
        <div class="info-block" style="margin-top:6px">
            <p class="label">Cabang Tujuan</p>
            <p class="value">{{ $payment->shipment?->destinationBranch?->name }} — {{ $payment->shipment?->destinationBranch?->city }}</p>
        </div>
    </div>
</div>

@if($payment->shipment?->items->count())
<div class="section">
    <div class="section-title">Detail Paket</div>
    <table>
        <thead>
            <tr>
                <th>Nama Item</th>
                <th style="width:80px;text-align:center">Qty</th>
                <th style="width:100px;text-align:right">Berat (kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->shipment->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td style="text-align:center">{{ $item->quantity }}</td>
                <td style="text-align:right">{{ $item->weight }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="section">
    <div class="section-title">Rincian Biaya</div>
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th style="text-align:right">Detail</th>
                <th style="width:150px;text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ongkos Kirim</td>
                <td style="text-align:right">
                    {{ $payment->shipment?->total_weight }} kg
                    @if($payment->shipment?->rate)
                    × Rp {{ number_format($payment->shipment->rate->price_per_kg, 0, ',', '.') }}
                    @endif
                </td>
                <td style="text-align:right">Rp {{ number_format($payment->shipment?->total_price ?? $payment->amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2"><strong>TOTAL PEMBAYARAN</strong></td>
                <td style="text-align:right" class="amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="display:flex;gap:24px;margin-top:8px;font-size:11px;">
        <div><span style="color:#9ca3af">Metode Bayar:</span> <strong>{{ ucfirst($payment->payment_method ?? '-') }}</strong></div>
        <div><span style="color:#9ca3af">Dibayar oleh:</span> <strong>{{ ucfirst($payment->shipment?->payer_type ?? '-') }}</strong></div>
        @if($payment->reference_number)
        <div><span style="color:#9ca3af">No. Referensi:</span> <strong>{{ $payment->reference_number }}</strong></div>
        @endif
    </div>
</div>

<div class="footer">
    <div class="note">
        <p><strong>Catatan:</strong></p>
        <p>Simpan kwitansi ini sebagai bukti pembayaran yang sah. Untuk pertanyaan, hubungi cabang terdekat.</p>
        <p style="margin-top:4px">Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }}</p>
    </div>
    <div class="sign">
        <div class="sign-line"></div>
        <p>Petugas Kasir</p>
        <p style="font-weight:600;margin-top:2px">{{ $payment->cashier?->name ?? Auth::user()?->name ?? 'Kasir' }}</p>
    </div>
</div>

</body>
</html>
