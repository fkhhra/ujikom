@props(['status'])
@php
$map = [
    'pending'           => ['Menunggu',        'bg-yellow-100 text-yellow-700'],
    'picked_up'         => ['Diambil Kurir',   'bg-blue-100 text-blue-700'],
    'in_transit'        => ['Dalam Perjalanan','bg-indigo-100 text-indigo-700'],
    'arrived_at_branch' => ['Tiba di Cabang',  'bg-purple-100 text-purple-700'],
    'out_for_delivery'  => ['Sedang Diantar',  'bg-orange-100 text-orange-700'],
    'delivered'         => ['Terkirim',        'bg-green-100 text-green-700'],
    'cancelled'         => ['Dibatalkan',      'bg-red-100 text-red-700'],
    'paid'              => ['Lunas',           'bg-green-100 text-green-700'],
    'unpaid'            => ['Belum Bayar',     'bg-red-100 text-red-700'],
    'failed'            => ['Gagal',           'bg-red-100 text-red-700'],
];
$s = $map[$status] ?? [ucfirst($status), 'bg-gray-100 text-gray-700'];
@endphp
<span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $s[1] }}">{{ $s[0] }}</span>
