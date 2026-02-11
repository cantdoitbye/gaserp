<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pngs', function (Blueprint $table) {
            // Change plan_type from enum to string to allow varied Excel values
            $table->string('plan_type')->nullable()->change();
            
            // Change connections_status from enum to string to support all possible statuses
            $table->string('connections_status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pngs', function (Blueprint $table) {
            // Fallback to the known enum values if needed, though this might lose data not in the enum
            $table->enum('plan_type', ['apartment', 'individual', 'commercial', 'domestic', 'bungalow', 'rowhouse', 'farmhouse', 'riser_hadder', 'dma', 'welded', 'o&m'])->nullable()->change();
            $table->enum('connections_status', ['workable', 'not_workable', 'plb_done', 'pdt_pending', 'gc_pending', 'mmt_pending', 'conv_pending', 'comm', 'bill_pending', 'bill_received', 'reported', 'report_pending'])->nullable()->change();
        });
    }
};
