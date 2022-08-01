<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** php artisan make:migration add_columns_to_memberinfo_table --table=memberinfo
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name', 10)->nullable();
            $table->string('code');
            $table->string('address')->nullable();
            $table->string('telephone_numbers')->nullable();
            $table->string('mobile_numbers')->nullable();
            $table->string('ntn_number')->nullable();
            $table->string('stn_number')->nullable();
            $table->string('sale_tax_rate')->nullable();
            $table->string('logo_file')->nullable();
            $table->integer('guest_charges')->nullable();
            $table->enum('guest_charges_type', ['per_person', 'percentage'])->nullable();
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
        Schema::dropIfExists('clubs');
    }
};
