<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('status');
            $table->integer('northwest_x');
            $table->integer('northwest_z');
            $table->integer('southeast_x');
            $table->integer('southeast_z');
            $table->integer('requested_by');
            $table->integer('shared');
            $table->integer('reviewed_by');

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
        
    }
}
