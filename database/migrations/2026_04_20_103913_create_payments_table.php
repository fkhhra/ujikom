<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->enum('payment_method', ['cash', 'transfer', 'e-wallet', 'qris'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->string('midtrans_order_id', 255)->nullable();
            $table->string('midtrans_transaction_id', 255)->nullable();
            $table->string('midtrans_bank', 50)->nullable();
            $table->string('midtrans_biller_code', 20)->nullable();
            $table->text('midtrans_va_number')->nullable();
            $table->text('midtrans_payment_code')->nullable();
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
