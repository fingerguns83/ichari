<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('oauth_id');
            $table->string('username');
            $table->string('oauth_unique');
            $table->string('avatar');
            $table->string('timezone')->default('UTC');
            $table->int('perm_level')->default('1');
            $table->integer('is_admin')->default('0');
            $table->integer('is_banned')->default('0');

            $table->rememberToken();
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
        //
    }
}
