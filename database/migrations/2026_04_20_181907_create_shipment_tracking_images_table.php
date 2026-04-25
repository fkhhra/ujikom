<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipment_tracking_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shipment_tracking_id');
            $table->string('image_path', 255);
            $table->timestamps();

            $table->foreign('shipment_tracking_id', 'st_images_st_id_foreign')
                  ->references('id')
                  ->on('shipment_trackings')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_tracking_images');
    }
};
