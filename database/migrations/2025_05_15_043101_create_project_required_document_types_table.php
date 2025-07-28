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
        Schema::create('project_required_document_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('legal_document_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate entries
            $table->unique(['project_id', 'legal_document_type_id'], 'project_document_type_unique');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_required_document_types');
    }
};
