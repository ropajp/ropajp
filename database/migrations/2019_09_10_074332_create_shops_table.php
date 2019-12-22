<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone_number')->nullable();
            $table->string('url')->nullable();
            $table->string('postcode', 8)->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('town_street')->nullable();
            $table->string('category')->nullable();
            $table->string('gender_for')->nullable();
            $table->string('brands')->nullable();
            $table->string('open_at')->nullable();
            $table->string('close_at')->nullable();
            $table->string('day_off')->nullable();
            $table->text('shop_detail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
