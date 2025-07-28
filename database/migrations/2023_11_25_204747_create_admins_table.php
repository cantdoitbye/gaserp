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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('role')->comment('1=Admin,2=Subadmin,3=Other');
            $table->tinyInteger('status')->comment('1=Active,2=Inactive')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('otp_code', 20)->nullable();
            $table->timestamp('otp_valid_date')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('admins');
    }
};
