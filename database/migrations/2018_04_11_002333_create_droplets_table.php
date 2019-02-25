<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droplets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->unsigned()->references('id')->on('subscriptions');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->string('name');
            $table->string('hostname', 32);
            $table->string('domain')->nullable();
            $table->string('desc')->nullable();
            $table->bigInteger('do_id')->unsigned()->nullable();
            $table->integer('memory')->unsigned()->nullable();
            $table->integer('vcpus')->unsigned()->nullable();
            $table->integer('disk')->unsigned()->nullable();
            $table->string('region')->nullable();
            $table->string('public_ip')->nullable();
            $table->string('private_ip')->nullable();
            $table->char('backup_enabled', 1)->nullable();
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
        Schema::dropIfExists('droplets');
    }
}
