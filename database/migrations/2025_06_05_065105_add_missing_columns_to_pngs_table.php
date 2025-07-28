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
            // Add the missing 'name' column that's causing the error
            if (!Schema::hasColumn('pngs', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            
            // Add other commonly missing columns
            $columnsToAdd = [
                'customer_no' => 'string',
                'order_no' => 'string', 
                'contact_no' => 'string',
                'plumber_name' => 'string',
                'plumbing_date' => 'date',
                'pdt_witness_by' => 'string',
                'ground_connections_date' => 'date',
                'ground_connections_witness_by' => 'string',
                'isolation_name' => 'string',
                'mmt_witness_by' => 'string',
                'conversion_technician_name' => 'string',
                'conversion_status' => 'string',
                'report_submission_date' => 'date',
                'ra_bill_no' => 'string',
                'connections_status' => 'string',
                'png_measurement_type_id' => 'unsignedBigInteger',
                'measurements_data' => 'json',
                'job_cards_paths' => 'json',
                'autocad_dwg_paths' => 'json',
                'site_visit_reports_paths' => 'json',
                'other_documents_paths' => 'json',
                'scan_copy_path' => 'string',
                'autocad_drawing_path' => 'string',
                'certificate_path' => 'string'
            ];
            
            foreach ($columnsToAdd as $columnName => $columnType) {
                if (!Schema::hasColumn('pngs', $columnName)) {
                    if ($columnType === 'string') {
                        $table->string($columnName)->nullable();
                    } elseif ($columnType === 'date') {
                        $table->date($columnName)->nullable();
                    } elseif ($columnType === 'json') {
                        $table->json($columnName)->nullable();
                    } elseif ($columnType === 'unsignedBigInteger') {
                        $table->unsignedBigInteger($columnName)->nullable();
                    }
                }
            }
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
              $columnsToRemove = [
                'name', 'customer_no', 'order_no', 'contact_no', 'plumber_name', 
                'plumbing_date', 'pdt_witness_by', 'ground_connections_date',
                'ground_connections_witness_by', 'isolation_name', 'mmt_witness_by',
                'conversion_technician_name', 'conversion_status', 'report_submission_date',
                'ra_bill_no', 'connections_status', 'png_measurement_type_id',
                'measurements_data', 'job_cards_paths', 'autocad_dwg_paths',
                'site_visit_reports_paths', 'other_documents_paths', 'scan_copy_path',
                'autocad_drawing_path', 'certificate_path'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('pngs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
