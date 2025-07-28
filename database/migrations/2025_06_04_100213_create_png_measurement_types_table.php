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
        Schema::create('png_measurement_types', function (Blueprint $table) {
          $table->id();
            $table->string('name'); // e.g., "Flat Type A", "House Type B", "Bungalow Standard"
            $table->string('png_type'); // e.g., "flat", "house", "bungalow", "commercial"
            $table->text('description')->nullable();
            $table->json('measurement_fields'); // Dynamic measurement fields configuration
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Modify existing pngs table
        Schema::table('pngs', function (Blueprint $table) {
            // Remove old fields that will be replaced by dynamic measurements
            $table->dropColumn([
                'gi_guard_to_main_valve_half_inch',
                'gi_main_valve_to_meter_half_inch', 
                'gi_meter_to_geyser_half_inch',
                'gi_geyser_point_half_inch',
                'extra_kitchen_point',
                'total_gi',
                'high_press_1_6_reg',
                'low_press_2_5_reg',
                'reg_qty',
                'gas_tap',
                'valve_half_inch',
                'gi_coupling_half_inch',
                'gi_elbow_half_inch',
                'calmp_half_inch',
                'gi_tee_half_inch',
                'anaconda',
                'open_cut_20mm',
                'boring_20mm',
                'total_mdpe_pipe_20mm',
                'tee_20mm',
                'rcc_guard_20mm',
                'gf_coupler_20mm',
                'gf_saddle_32x20mm',
                'gf_saddle_63x20mm',
                'gf_saddle_63x32mm',
                'gf_saddle_125x32',
                'gf_saddle_90x20mm',
                'gf_reducer_32x20mm'
            ]);

            // Add new fields to match Excel design
            $table->unsignedBigInteger('png_measurement_type_id')->nullable()->after('id');
            $table->json('measurements_data')->nullable(); // Store dynamic measurements
            
            // New file storage columns
            $table->json('job_cards_paths')->nullable(); // Job Cards files
            $table->json('autocad_dwg_paths')->nullable(); // AutoCad DWG files  
            $table->json('site_visit_reports_paths')->nullable(); // Site Visit Reports
            $table->json('other_documents_paths')->nullable(); // Other documents
            
            // Basic Information fields (matching Excel)
            $table->string('customer_no')->nullable()->after('service_order_no');
            $table->string('order_no')->nullable()->after('customer_no');
            $table->string('area')->nullable(); // Bungalow, Tapping, Row-house, Floor TF
            $table->string('scheme')->nullable(); // Days counts from, Agreement Date
            
            // Technical Information fields (matching Excel)
            $table->enum('connections_status', [
                'workable', 'not_workable', 'plb_done', 'pdt_pending', 
                'gc_pending', 'mmt_pending', 'conv_pending', 'comm', 
                'bill_pending', 'bill_received'
            ])->nullable();
            
            $table->string('pdt_witness_by')->nullable();
            $table->date('ground_connections_date')->nullable();
            $table->string('ground_connections_witness_by')->nullable();
            $table->string('isolation_name')->nullable();
            $table->string('mmt_witness_by')->nullable();
            $table->string('conversion_technician_name')->nullable();
            $table->enum('conversion_status', ['conv_done', 'comm', 'pending'])->nullable();
            $table->date('report_submission_date')->nullable();
            $table->string('ra_bill_no')->nullable();
            $table->text('remarks')->nullable();

            // Add foreign key
            $table->foreign('png_measurement_type_id')->references('id')->on('png_measurement_types')->onDelete('set null');
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
            $table->dropForeign(['png_measurement_type_id']);
            $table->dropColumn([
                'png_measurement_type_id',
                'measurements_data',
                'customer_no',
                'order_no', 
                'area',
                'scheme',
                'connections_status',
                'pdt_witness_by',
                'ground_connections_date',
                'ground_connections_witness_by',
                'isolation_name',
                'mmt_witness_by',
                'conversion_technician_name',
                'conversion_status',
                'report_submission_date',
                'ra_bill_no',
                'remarks'
            ]);
        });

        Schema::dropIfExists('png_measurement_types');
    }
};
