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
        Schema::create('legal_notifications', function (Blueprint $table) {
            $table->id();         
            $table->unsignedBigInteger('project_legal_document_id');
            $table->foreign('project_legal_document_id')->references('id')->on('project_legal_documents')->onDelete('cascade');
            
            $table->enum('notification_type', ['expiry', 'compliance', 'reminder']);
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->date('notification_date');
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
        Schema::dropIfExists('legal_notifications');
    }
};
