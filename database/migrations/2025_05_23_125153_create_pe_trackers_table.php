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
        Schema::create('pe_trackers', function (Blueprint $table) {
           $table->id();
            
            // Basic Information
            $table->date('date');
            $table->string('dpr_no')->nullable();
            $table->text('sites_names');
            $table->enum('activity', [
                'LAYING',
                'COMMISSIONING', 
                'EXCAVATION',
                'FLUSHING',
                'JOINT',
                'SR INSTALLATION'
            ]);
            $table->string('mukadam_name')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('tpi_name')->nullable();
            $table->string('ra_bill_no')->nullable();
            
            // Store all measurement and work data as JSON
            // This allows for flexible schema without many null columns
            $table->json('measurements')->nullable(); // All the MM measurements, boring data, etc.
            $table->json('installation_data')->nullable(); // Installation related data
            $table->json('pipe_fittings')->nullable(); // All pipe and fitting data
            $table->json('testing_data')->nullable(); // Flushing/testing/commissioning data
            
            // Commonly used fields for filtering/searching
            $table->decimal('total_laying_length', 10, 2)->nullable();
            $table->string('project_status')->default('active');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['date', 'activity']);
            $table->index('dpr_no');
            $table->index('project_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pe_trackers');
    }
};
