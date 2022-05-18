<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id');
            $table->string('initial_amount');
            $table->string('amount');
            $table->string("block_reason")->nullable();
            $table->string("unblock_reason")->nullable();
            $table->text("props")->nullable();
            $table->timestamp("expired_at")->nullable();
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
        Schema::dropIfExists('wallet_blocks');
    }
};
