<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('status');
            $table->string('name');
            $table->string('phone');
            $table->string('street');
            $table->string('building');
            $table->string('entrance')->nullable();
            $table->string('house')->nullable();
            $table->string('apartment')->nullable();
            $table->string('floor')->nullable();
            $table->boolean('call')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->boolean('payment')->nullable();
            $table->string('change')->nullable();
            $table->int('persons')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('sticks')->nullable();
            $table->decimal('totalSum', 10, 2);
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
        Schema::dropIfExists('orders');
    }
}
