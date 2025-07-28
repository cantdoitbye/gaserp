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
            if (!Schema::hasColumn('pngs', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('pngs', 'contact_no')) {
                $table->string('contact_no')->nullable();
            }

              if (!Schema::hasColumn('pngs', 'address')) {
                $table->string('address')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'png_measurement_type_id')) {
                $table->unsignedBigInteger('png_measurement_type_id')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'measurements_data')) {
                $table->json('measurements_data')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'job_cards_paths')) {
                $table->json('job_cards_paths')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'autocad_dwg_paths')) {
                $table->json('autocad_dwg_paths')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'site_visit_reports_paths')) {
                $table->json('site_visit_reports_paths')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'other_documents_paths')) {
                $table->json('other_documents_paths')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'customer_no')) {
                $table->string('customer_no')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'order_no')) {
                $table->string('order_no')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'connections_status')) {
                $table->string('connections_status')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'pdt_witness_by')) {
                $table->string('pdt_witness_by')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'ground_connections_date')) {
                $table->date('ground_connections_date')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'ground_connections_witness_by')) {
                $table->string('ground_connections_witness_by')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'isolation_name')) {
                $table->string('isolation_name')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'mmt_witness_by')) {
                $table->string('mmt_witness_by')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'conversion_technician_name')) {
                $table->string('conversion_technician_name')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'conversion_status')) {
                $table->string('conversion_status')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'report_submission_date')) {
                $table->date('report_submission_date')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'ra_bill_no')) {
                $table->string('ra_bill_no')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'scan_copy_path')) {
                $table->string('scan_copy_path')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'autocad_drawing_path')) {
                $table->string('autocad_drawing_path')->nullable();
            }
            
            if (!Schema::hasColumn('pngs', 'certificate_path')) {
                $table->string('certificate_path')->nullable();
            }
        });

        // // Add foreign key if it doesn't exist
        // if (Schema::hasColumn('pngs', 'png_measurement_type_id')) {
        //     try {
        //         Schema::table('pngs', function (Blueprint $table) {
        //             $table->foreign('png_measurement_type_id')->references('id')->on('png_measurement_types')->onDelete('set null');
        //         });
        //     } catch (\Exception $e) {
        //         // Foreign key might already exist, ignore the error
        //     }
        // }
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pngs', function (Blueprint $table) {
               try {
                $table->dropForeign(['png_measurement_type_id']);
            } catch (\Exception $e) {
                // Ignore if foreign key doesn't exist
            }
            
            // Drop columns if they exist
            $columnsToRemove = [
                'name', 'contact_no', 'png_measurement_type_id', 'measurements_data',
                'job_cards_paths', 'autocad_dwg_paths', 'site_visit_reports_paths', 'other_documents_paths',
                'customer_no', 'order_no', 'connections_status', 'pdt_witness_by',
                'ground_connections_date', 'ground_connections_witness_by', 'isolation_name',
                'mmt_witness_by', 'conversion_technician_name', 'conversion_status',
                'report_submission_date', 'ra_bill_no', 'scan_copy_path', 'autocad_drawing_path', 'certificate_path'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('pngs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
