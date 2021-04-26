<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("from_id")->nullable(false);
            $table->uuid('to_id')->nullable(false);
            $table->string("audio_path")->nullable(false)->unique();
            $table->boolean("delivered")->default(false);
            $table->timestamps();

            $table->foreign("from_id")
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign("to_id")
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
        Schema::dropIfExists('posts');
    }
}
