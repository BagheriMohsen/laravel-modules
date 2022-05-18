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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->nullable();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->text('bio')->nullable();
            $table->string('cellphone', 15)->unique();
            $table->timestamp('cellphone_verified_at')->nullable();
            $table->string('national_code')->unique();
            $table->timestamp('national_code_verified_at')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_superuser')->default(false);
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('users');
    }
};
