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
        Schema::table('projects', function (Blueprint $table) {
              // Tender related fields
            $table->string('tender_id')->nullable()->after('contract_number');
            $table->date('prebid_meeting_date')->nullable()->after('tender_id');
            $table->date('tender_submit_date')->nullable()->after('prebid_meeting_date');
            $table->decimal('price_open_percentage', 8, 2)->nullable()->after('tender_submit_date');
            $table->date('kick_off_meeting_date')->nullable()->after('price_open_percentage');
            
            // Contract related fields
            $table->decimal('contact_value', 15, 2)->nullable()->after('kick_off_meeting_date');
            $table->decimal('contract_value_consumption', 15, 2)->nullable()->after('contact_value');
            $table->decimal('contract_balance', 15, 2)->nullable()->after('contract_value_consumption');
            
            // Amendment fields
            $table->date('amendment_date')->nullable()->after('contract_balance');
            $table->decimal('amendment_value', 15, 2)->nullable()->after('amendment_date');
            
            // Labor license fields
            $table->string('labour_licence_number')->nullable()->after('amendment_value');
            $table->date('licence_application_date')->nullable()->after('labour_licence_number');
       
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
             $table->dropColumn([
                'tender_id',
                'prebid_meeting_date',
                'tender_submit_date',
                'price_open_percentage',
                'kick_off_meeting_date',
                'contact_value',
                'contract_value_consumption',
                'contract_balance',
                'amendment_date',
                'amendment_value',
                'labour_licence_number',
                'licence_application_date'
            ]);
        });
    }
};
