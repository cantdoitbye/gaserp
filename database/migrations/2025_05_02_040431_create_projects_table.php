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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contract_number')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_contact')->nullable();
            $table->string('project_manager')->nullable();
            $table->float('pipeline_length', 10, 2)->nullable()->comment('Length in kilometers');
            $table->string('pipeline_type')->nullable()->comment('e.g. High-pressure, Low-pressure, etc.');
            $table->string('pipeline_material')->nullable()->comment('e.g. Steel, HDPE, etc.');
            $table->enum('service_type', ['installation', 'repair', 'maintenance', 'inspection', 'mixed'])->default('installation');
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
