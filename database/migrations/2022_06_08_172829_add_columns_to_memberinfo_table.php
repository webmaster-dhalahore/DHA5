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
        Schema::table('memberinfo', function (Blueprint $table) {
            $table->integer('club_id')->nullable();
            $table->string('rank')->nullable();
            $table->integer('parent_membersr')->nullable();
            $table->string('picture')->nullable();
            $table->string('signature')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('mobileno2')->nullable();
            // $table->string('phoneresidence', 60)->change();
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
        Schema::table('memberinfo', function (Blueprint $table) {
            //
        });
    }
};
