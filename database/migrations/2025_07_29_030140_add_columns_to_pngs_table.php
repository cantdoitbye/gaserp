<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            // Comment out dynamic measurement fields (keeping for future use)
            $table->text('dynamic_measurements_backup')->nullable()->comment('Backup of old dynamic measurements');
            
            // Basic Information Fields (from Excel images)
            if (!Schema::hasColumn('pngs', 'po_number')) {
                $table->string('po_number')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'booking_by')) {
                $table->string('booking_by')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'plan_type')) {
                $table->string('plan_type')->nullable();
                // $table->enum('plan_type', ['apartment', 'individual', 'commercial'])->nullable();

            }
            if (!Schema::hasColumn('pngs', 'notification_numbers')) {
                $table->string('notification_numbers')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'house_no')) {
                $table->string('house_no')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'street_1')) {
                $table->string('street_1')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'street_2')) {
                $table->string('street_2')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'street_3')) {
                $table->string('street_3')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'street_4')) {
                $table->string('street_4')->nullable();
            }
            
            // Witnesses and Technical Information
            if (!Schema::hasColumn('pngs', 'witnesses_name_date')) {
                $table->string('witnesses_name_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'witnesses_name_date_2')) {
                $table->string('witnesses_name_date_2')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'previous_remarks')) {
                $table->text('previous_remarks')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'current_remarks')) {
                $table->text('current_remarks')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'reported')) {
                $table->string('reported')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'plb_name')) {
                $table->string('plb_name')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'plb_date')) {
                $table->date('plb_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'pdt_date')) {
                $table->date('pdt_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'pdt_tpi')) {
                $table->string('pdt_tpi')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'gc_date')) {
                $table->date('gc_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'gc_tpi')) {
                $table->string('gc_tpi')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'mmt_tpi')) {
                $table->string('mmt_tpi')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'conversion_payment')) {
                $table->decimal('conversion_payment', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('pngs', 'meter_reading')) {
                $table->decimal('meter_reading', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('pngs', 'plumber')) {
                $table->string('plumber')->nullable();
            }
            
            // MMT and Conversion Details
            if (!Schema::hasColumn('pngs', 'mmt_date')) {
                $table->date('mmt_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'conversion_date')) {
                $table->date('conversion_date')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'conversion_technician')) {
                $table->string('conversion_technician')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'date_of_report')) {
                $table->date('date_of_report')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'meter_number')) {
                $table->string('meter_number')->nullable();
            }
            
            // All specific measurement fields from Excel
            // GI (Galvanized Iron) Measurements 
            $table->decimal('gi_guard_to_main_valve_half_inch', 8, 2)->nullable();
            $table->decimal('gi_main_valve_to_meter_half_inch', 8, 2)->nullable();
            $table->decimal('gi_meter_to_geyser_half_inch', 8, 2)->nullable();
            $table->decimal('gi_geyser_point_half_inch', 8, 2)->nullable();
            $table->decimal('extra_kitchen_point', 8, 2)->nullable();
            $table->decimal('total_gi', 8, 2)->nullable();
            
            // Regulators and Components
            $table->integer('high_press_1_6_reg')->nullable();
            $table->integer('low_press_2_5_reg')->nullable();
            $table->integer('reg_qty')->nullable();
            $table->integer('gas_tap')->nullable();
            $table->integer('valve_half_inch')->nullable();
            $table->integer('gi_coupling_half_inch')->nullable();
            $table->integer('gi_elbow_half_inch')->nullable();
            $table->integer('clamp_half_inch')->nullable();
            $table->integer('gi_tee_half_inch')->nullable();
            $table->integer('anaconda')->nullable();
            
            // Pipe and Excavation
            $table->decimal('open_cut_20mm', 8, 2)->nullable();
            $table->decimal('boring_20mm', 8, 2)->nullable();
            $table->decimal('total_mdpe_pipe_20mm', 8, 2)->nullable();
            $table->integer('tee_20mm')->nullable();
            $table->integer('rcc_guard_20mm')->nullable();
            
            // GF (Gas Fittings) Components
            $table->integer('gf_coupler_20mm')->nullable();
            $table->integer('gf_saddle_32x20mm')->nullable();
            $table->integer('gf_saddle_63x20mm')->nullable();
            $table->integer('gf_saddle_63x32mm')->nullable();
            $table->integer('gf_saddle_125x32')->nullable();
            $table->integer('gf_saddle_90x20mm')->nullable();
            $table->integer('gf_reducer_32x20mm')->nullable();
            
            // NEPL Claims and Drawings
            if (!Schema::hasColumn('pngs', 'nepl_claim')) {
                $table->string('nepl_claim')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'offline_drawing')) {
                $table->string('offline_drawing')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'gc_done_by')) {
                $table->string('gc_done_by')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'v_lookup')) {
                $table->string('v_lookup')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'created_at_field')) {
                $table->timestamp('created_at_field')->nullable();
            }
            if (!Schema::hasColumn('pngs', 'updated_at_field')) {
                $table->timestamp('updated_at_field')->nullable();
            }
        });
        
        // Backup existing dynamic measurements data before commenting out
        DB::statement("UPDATE pngs SET dynamic_measurements_backup = measurements_data WHERE measurements_data IS NOT NULL");
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('pngs', function (Blueprint $table) {
            // Remove all the specific measurement fields
            $table->dropColumn([
                'dynamic_measurements_backup',
                'witnesses_name_date',
                'witnesses_name_date_2', 
                'previous_remarks',
                'current_remarks',
                'reported',
                'pdt_tpi',
                'gc_tpi',
                'mmt_tpi',
                'conversion_payment',
                'plumber',
                'conversion_technician',
                'date_of_report',
                
                // Measurement fields
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
                'clamp_half_inch',
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
                'gf_reducer_32x20mm',
                'created_at_field',
                'updated_at_field'
            ]);
        });
        
        // Restore dynamic measurements if needed
        DB::statement("UPDATE pngs SET measurements_data = dynamic_measurements_backup WHERE dynamic_measurements_backup IS NOT NULL");
    }
    
};
