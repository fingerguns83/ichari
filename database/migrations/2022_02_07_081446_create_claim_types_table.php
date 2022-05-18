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
            $table->longText('preapportioned');
            $table->integer('size');
            $table->integer('shareable');
            $table->integer('shared_size');
            $table->integer('buffer');
            $table->integer('area_allowed');
            $table->integer('amount_allowed');
            $table->integer('review_requires_team');
            $table->bigInteger('expire_time');

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
