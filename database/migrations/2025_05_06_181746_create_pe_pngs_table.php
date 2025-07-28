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
        Schema::create('pe_pngs', function (Blueprint $table) {
            $table->id();
            $table->string('job_order_number')->unique();
            $table->enum('category', ['domestic', 'commercial', 'riser', 'gc', 'conversion'])->default('domestic');
            $table->date('plumbing_date');
            $table->foreignId('plumber_id')->nullable()->constrained('plumbers')->onDelete('set null');
            $table->date('gc_date')->nullable();
            $table->date('mmt_date')->nullable();
            $table->json('site_visits')->nullable(); // Store multiple site visits as JSON
            $table->text('remarks')->nullable();
            $table->string('bill_ra_no')->nullable();
            $table->enum('plb_bill_status', ['pending', 'processed', 'paid', 'locked'])->default('pending');
            $table->string('scan_copy_path')->nullable(); // Store file path
            $table->integer('sla_days')->nullable();
            $table->text('pe_dpr')->nullable();
            $table->string('autocad_drawing_path')->nullable(); // Store file path
            $table->json('consumption_details')->nullable(); // Store consumption details as JSON
            $table->json('free_issue_details')->nullable(); // Store free issue details as JSON
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
        Schema::dropIfExists('pe_pngs');
    }
};
