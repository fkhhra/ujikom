<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Payment;
use App\Models\ShipmentTracking;
use App\Models\Customer;
use App\Models\User;
use App\Models\Branch;
use App\Models\Rate;
use Carbon\Carbon;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $branches = Branch::all();
        $couriers = User::where('role', 'courier')->get();
        $rates = Rate::all();

        if ($customers->count() < 10 || $branches->count() < 4 || $couriers->count() < 5 || $rates->isEmpty()) {
            return;
        }

        $shipmentTemplates = [
            [
                'prefix' => 'TRV20240001',
                'status' => 'delivered',
                'days_ago' => 10,
                'items' => [
                    ['item_name' => 'Baju Batik', 'quantity' => 3, 'weight' => 2.00],
                    ['item_name' => 'Celana Jeans', 'quantity' => 2, 'weight' => 3.00],
                ],
            ],
            [
                'prefix' => 'TRV20240002',
                'status' => 'in_transit',
                'days_ago' => 3,
                'items' => [
                    ['item_name' => 'Buku Pelajaran', 'quantity' => 5, 'weight' => 2.50],
                    ['item_name' => 'Alat Tulis', 'quantity' => 1, 'weight' => 1.00],
                ],
            ],
            [
                'prefix' => 'TRV20240003',
                'status' => 'pending',
                'days_ago' => 0,
                'items' => [
                    ['item_name' => 'Elektronik', 'quantity' => 1, 'weight' => 7.00],
                ],
            ],
            [
                'prefix' => 'TRV20240004',
                'status' => 'out_for_delivery',
                'days_ago' => 2,
                'items' => [
                    ['item_name' => 'Sepatu Olahraga', 'quantity' => 2, 'weight' => 4.00],
                ],
            ],
        ];

        foreach ($shipmentTemplates as $index => $tpl) {
            $sender = $customers[$index * 2];
            $receiver = $customers[$index * 2 + 1];
            $origin = $branches->first();
            $dest = $branches->last();
            $courier = $couriers->random();
            $rate = $rates->where('origin_city', $origin->city)->where('destination_city', $dest->city)->first() ?? $rates->first();

            $shipment = Shipment::create([
                'tracking_number'       => $tpl['prefix'] . chr(65 + $index) . chr(66 + $index),
                'sender_id'             => $sender->id,
                'receiver_id'           => $receiver->id,
                'origin_branch_id'      => $origin->id,
                'destination_branch_id' => $dest->id,
                'current_branch_id'     => $origin->id,
                'courier_id'            => $tpl['status'] === 'pending' ? null : $courier->id,
                'rate_id'               => $rate->id,
                'total_weight'          => collect($tpl['items'])->sum('weight'),
                'total_price'           => collect($tpl['items'])->sum('weight') * $rate->price_per_kg,
                'status'                => $tpl['status'],
                'shipment_date'         => Carbon::now()->subDays($tpl['days_ago'])->toDateString(),
            ]);

            foreach ($tpl['items'] as $item) {
                ShipmentItem::create(array_merge(['shipment_id' => $shipment->id], $item));
            }

            Payment::create([
                'shipment_id' => $shipment->id,
                'amount' => $shipment->total_price,
                'payment_method' => 'transfer',
                'payment_status' => $tpl['status'] === 'pending' ? 'pending' : 'paid',
                'payment_date' => $tpl['status'] === 'pending' ? null : Carbon::now()->subDays($tpl['days_ago'])->toDateString(),
                'midtrans_order_id' => $shipment->tracking_number . '-PAY',
            ]);

            if ($tpl['status'] !== 'pending') {
                ShipmentTracking::create([
                    'shipment_id' => $shipment->id,
                    'location' => $origin->city,
                    'description' => 'Paket diterima di ' . $origin->name,
                    'status' => 'picked_up',
                    'tracked_at' => Carbon::now()->subDays($tpl['days_ago']),
                    'branch_id' => $origin->id
                ]);
            }
        }
    }
}
