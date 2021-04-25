<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('from_id')->nullable();
            $table->string('latest_audio_path')->nullable();
            $table->timestamps();

            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('from_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_statuses');
    }
}
