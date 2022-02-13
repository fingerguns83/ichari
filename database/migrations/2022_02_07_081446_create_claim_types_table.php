<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimTypesTable extends Migration
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
            $table->integer('size');
            $table->integer('shareable');
            $table->string('alternate_trigger');
            $table->string('alternate_measured_by');
            $table->integer('alternate_size');
            $table->integer('prompt_id');
            $table->text('area_allowed');
            $table->integer('amount_allowed');
            $table->integer('review_requires_team');
            $table->integer('buffer');

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
