<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('role_id')->unsigned()->default(2);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('name');

            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('entrance')->nullable();
            $table->string('house')->nullable();
            $table->string('apartment')->nullable();
            $table->string('floor')->nullable();

            $table->boolean('gender')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();   
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Artisan::call('db:seed', ['--class' => UsersTableInsertAdminSeeder::class,]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
