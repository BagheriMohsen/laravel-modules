<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Entities\Payment;

return new class extends Migration
{

    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('amount');
            $table->text('tracking_code');
            $table->text('card_number');
            $table->text('sent_date')->nullable();
            $table->text('receive_data')->nullable();
            $table->text('props')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('user_note')->nullable();
            $table->string('status')->default(Payment::STATUS_PENDING);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
