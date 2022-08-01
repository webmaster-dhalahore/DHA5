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
        Schema::create('emails_mst', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('emails_dtl', function (Blueprint $table) {
            $table->id();
            $table->integer('emails_mst_id')->nullable();
            $table->integer('membersr');
            $table->string('membername');
            $table->string('email');
            $table->char('is_success',1)->nullable();
            $table->timestamps();

            // $table->foreign('emails_mst_id')
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails_mst');
    }
};
