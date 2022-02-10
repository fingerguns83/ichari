<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClaimTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('icon');
            $table->string('measured_by');
            $table->int('size');
            $table->string('alternate_trigger');
            $table->int('alternate_size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
