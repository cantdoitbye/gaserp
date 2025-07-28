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
        Schema::create('project_legal_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            
            $table->unsignedBigInteger('legal_document_type_id');
$table->foreign('legal_document_type_id')->references('id')->on('legal_document_types')->onDelete('cascade');
            $table->boolean('is_required')->default(true);
            $table->date('issue_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->string('document_file')->nullable();
            $table->enum('status', ['pending', 'valid', 'expired', 'upcoming_expiry'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_legal_documents');
    }
};
