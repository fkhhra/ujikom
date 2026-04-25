<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_number', 255)->unique()->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('origin_branch_id')->nullable();
            $table->unsignedBigInteger('destination_branch_id')->nullable();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->decimal('total_price', 15, 2)->nullable();
            $table->enum('payer_type', ['sender', 'receiver'])->default('sender');
            $table->unsignedBigInteger('current_branch_id')->nullable();
            $table->enum('status', [
                'pending',
                'picked_up',
                'in_transit',
                'arrived_at_branch',
                'out_for_delivery',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->date('shipment_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('receiver_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('origin_branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('destination_branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('current_branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('courier_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rate_id')->references('id')->on('rates')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
