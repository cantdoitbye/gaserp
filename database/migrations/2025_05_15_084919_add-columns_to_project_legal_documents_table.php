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
        Schema::table('project_legal_documents', function (Blueprint $table) {
              $table->string('license_number')->nullable()->after('legal_document_type_id');
            $table->date('application_date')->nullable()->after('issue_date');
            $table->date('reapply_date')->nullable()->after('validity_date');
            $table->string('reapplication_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_legal_documents_', function (Blueprint $table) {
                        $table->dropColumn(['license_number', 'application_date', 'reapply_date', 'reapplication_status']);

        });
    }
};
