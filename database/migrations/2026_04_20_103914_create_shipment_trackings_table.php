<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipment_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', [
                'picked_up',
                'in_transit',
                'arrived_at_branch',
                'out_for_delivery',
                'delivered'
            ])->nullable();
            $table->timestamp('tracked_at')->nullable();
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_trackings');
    }
};
