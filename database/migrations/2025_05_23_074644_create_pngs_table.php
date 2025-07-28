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
        Schema::create('pngs', function (Blueprint $table) {
          $table->id();
            
            // Basic Information
            $table->string('po_number')->nullable();
            $table->string('service_order_no')->unique();
            $table->date('agreement_date')->nullable();
            $table->string('booking_by')->nullable();
            $table->date('start_date')->nullable();
            $table->enum('plan_type', ['apartment', 'individual', 'commercial'])->nullable();
            $table->string('customer')->nullable();
            $table->string('application_no')->nullable();
            $table->string('notification_numbers')->nullable();
            $table->string('customer_name');
            $table->string('house_no')->nullable();
            $table->string('street_1')->nullable();
            $table->string('street_2')->nullable();
            $table->string('street_3')->nullable();
            $table->string('street_4')->nullable();
            $table->string('customer_contact_no')->nullable();
            
            // Additional Customer Information
            $table->integer('geyser_point')->default(0);
            $table->integer('extra_kitchen')->default(0);
            $table->integer('sla_days')->nullable();
            $table->text('current_remarks')->nullable();
            $table->string('witnesses_name_date')->nullable();
            $table->text('previous_remarks')->nullable();
            $table->string('witnesses_name_date_2')->nullable();
            $table->string('reported')->nullable();
            $table->string('plb_name')->nullable();
            $table->date('plb_date')->nullable();
            $table->date('pdt_date')->nullable();
            $table->string('pdt_tpi')->nullable();
            $table->string('pe_status')->nullable();
            $table->date('gc_date')->nullable();
            $table->string('gc_tpi')->nullable();
            $table->date('mmt_date')->nullable();
            $table->string('mmt_tpi')->nullable();
            $table->date('conversion_date')->nullable();
            
            // Conversion Details
            $table->string('conversion_technician')->nullable();
            $table->date('date_of_report')->nullable();
            $table->string('plumber')->nullable();
            $table->string('conversion_payment')->nullable();
            $table->string('meter_number')->nullable();
            $table->decimal('meter_reading', 8, 2)->nullable();
            
            // GI Pipe Measurements (in decimal for precise measurements)
            $table->decimal('gi_guard_to_main_valve_half_inch', 8, 2)->nullable();
            $table->decimal('gi_main_valve_to_meter_half_inch', 8, 2)->nullable();
            $table->decimal('gi_meter_to_geyser_half_inch', 8, 2)->nullable();
            $table->decimal('gi_geyser_point_half_inch', 8, 2)->nullable();
            $table->decimal('extra_kitchen_point', 8, 2)->nullable();
            $table->decimal('total_gi', 8, 2)->nullable();
            
            // Regulators and Components
            $table->integer('high_press_1_6_reg')->default(0);
            $table->integer('low_press_2_5_reg')->default(0);
            $table->integer('reg_qty')->default(0);
            $table->integer('gas_tap')->default(0);
            $table->integer('valve_half_inch')->default(0);
            $table->integer('gi_coupling_half_inch')->default(0);
            
            // Fittings
            $table->integer('gi_elbow_half_inch')->default(0);
            $table->integer('calmp_half_inch')->default(0);
            $table->integer('gi_tee_half_inch')->default(0);
            $table->integer('anaconda')->default(0);
            $table->decimal('open_cut_20mm', 8, 2)->default(0);
            $table->decimal('boring_20mm', 8, 2)->default(0);
            $table->decimal('total_mdpe_pipe_20mm', 8, 2)->default(0);
            $table->integer('tee_20mm')->default(0);
            $table->integer('rcc_guard_20mm')->default(0);
            $table->integer('gf_coupler_20mm')->default(0);
            
            // GF Saddles
            $table->integer('gf_saddle_32x20mm')->default(0);
            $table->integer('gf_saddle_63x20mm')->default(0);
            $table->integer('gf_saddle_63x32mm')->default(0);
            $table->integer('gf_saddle_125x32')->default(0);
            $table->integer('gf_saddle_90x20mm')->default(0);
            $table->integer('gf_reducer_32x20mm')->default(0);
            
            // Additional Fields
            $table->string('nepl_claim')->nullable();
            $table->string('offline_drawing')->nullable();
            $table->string('gc_done_by')->nullable();
            $table->string('v_lookup')->nullable();
            
            // File Storage
            $table->string('scan_copy_path')->nullable();
            $table->string('autocad_drawing_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->json('additional_documents')->nullable();
            
            $table->timestamps();

            // Indexes for better performance
            $table->index(['service_order_no']);
            $table->index(['customer_name']);
            $table->index(['plan_type', 'start_date']);
            $table->index(['pe_status']);
            $table->index(['reported']);
            $table->index(['plumber']);
            $table->index(['gc_tpi']);
            $table->index(['conversion_date']);
            $table->index(['start_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pngs');
    }
};
