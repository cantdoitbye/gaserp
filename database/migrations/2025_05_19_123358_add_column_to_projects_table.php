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
        Schema::table('projects', function (Blueprint $table) {
            DB::statement('ALTER TABLE projects ADD COLUMN old_service_type VARCHAR(255)');
        DB::statement('UPDATE projects SET old_service_type = service_type');
        
        // Update the projects table
        Schema::table('projects', function (Blueprint $table) {
            // Add tender_id if it doesn't exist
            if (!Schema::hasColumn('projects', 'tender_id')) {
                $table->string('tender_id')->nullable();
            }
            
            // Modify service_type to service_type_id
            $table->dropColumn('service_type');
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types');
        });
        
        // Migrate old service_type data to new relationship
        DB::statement("
            UPDATE projects p
            JOIN service_types st ON st.name = p.old_service_type
            SET p.service_type_id = st.id
            WHERE p.old_service_type IS NOT NULL
        ");
        
        // Remove the backup column
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('old_service_type');
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
                 $table->string('service_type')->nullable();
            
            // Create temporary backup
            DB::statement('UPDATE projects p JOIN service_types st ON p.service_type_id = st.id SET p.service_type = st.name');
            
            // Drop foreign key and column
            $table->dropForeign(['service_type_id']);
            $table->dropColumn('service_type_id');
            
            // Drop tender_id if we added it
            if (Schema::hasColumn('projects', 'tender_id')) {
                $table->dropColumn('tender_id');
            }
        });
    }
};
