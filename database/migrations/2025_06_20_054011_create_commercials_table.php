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
        Schema::create('commercials', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->date('agreement_date')->nullable();
            $table->string('customer_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('service_order_no')->nullable();
            $table->string('application_no')->nullable();
            $table->string('contact_no')->nullable();
            $table->text('address')->nullable();
            $table->text('area')->nullable();
            $table->string('scheme')->nullable();
            $table->integer('sla_days')->nullable();
            
            // Service information
            $table->string('po_number')->nullable();
            $table->date('start_date')->nullable();
            $table->string('booking_by')->nullable();
            $table->string('plan_type')->nullable();
            $table->text('notification_numbers')->nullable();
            $table->string('house_no')->nullable();
            $table->string('street_1')->nullable();
            $table->string('street_2')->nullable();
            $table->string('street_3')->nullable();
            $table->string('street_4')->nullable();
            
            // Technical Information
            $table->string('connections_status')->nullable();
            $table->string('plb_name')->nullable();
            $table->date('plb_date')->nullable();
            $table->date('pdt_date')->nullable();
            $table->string('pdt_witness_by')->nullable();
            $table->date('ground_connections_date')->nullable();
            $table->string('ground_connections_witness_by')->nullable();
            $table->string('isolation_name')->nullable();
            $table->date('mmt_date')->nullable();
            $table->string('mmt_witness_by')->nullable();
            $table->string('conversion_technician_name')->nullable();
            $table->date('conversion_date')->nullable();
            $table->string('conversion_status')->nullable();
            $table->date('report_submission_date')->nullable();
            $table->string('meter_number')->nullable();
            $table->string('ra_bill_no')->nullable();
            $table->text('remarks')->nullable();
            
            // Team information
            $table->string('pe_status')->nullable();
            $table->string('reported')->nullable();
            $table->string('pdt_tpi')->nullable();
            $table->date('gc_date')->nullable();
            $table->string('gc_tpi')->nullable();
            $table->string('mmt_tpi')->nullable();
            $table->string('conversion_payment')->nullable();
            $table->decimal('meter_reading', 10, 2)->nullable();
            $table->string('plumber')->nullable();
            $table->text('witnesses_name_date')->nullable();
            $table->text('witnesses_name_date_2')->nullable();
            $table->text('current_remarks')->nullable();
            $table->text('previous_remarks')->nullable();
            $table->string('nepl_claim')->nullable();
            $table->string('offline_drawing')->nullable();
            $table->string('gc_done_by')->nullable();
            $table->string('v_lookup')->nullable();
            
            // Dynamic measurements
            $table->unsignedBigInteger('png_measurement_type_id')->nullable();
            $table->json('measurements_data')->nullable();
            
            // File paths
            $table->string('scan_copy_path')->nullable();
            $table->string('autocad_drawing_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->json('job_cards_paths')->nullable();
            $table->json('autocad_dwg_paths')->nullable();
            $table->json('site_visit_reports_paths')->nullable();
            $table->json('other_documents_paths')->nullable();
            $table->json('additional_documents')->nullable();
            
            $table->string('commercial_type')->nullable();
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('png_measurement_type_id')->references('id')->on('png_measurement_types')->onDelete('set null');
            
            // Indexes
            $table->index(['connections_status']);
            $table->index(['conversion_status']);
            $table->index(['agreement_date']);
            $table->index(['customer_name']);
            $table->index(['area']);
            $table->index(['scheme']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commercials');
    }
};
