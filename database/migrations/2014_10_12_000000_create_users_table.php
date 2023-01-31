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
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->bigInteger('indicacao');
            $table->enum('ativo',['0','1','3']);
            $table->bigInteger('celular')->nullable();
            $table->bigInteger('cpf');
            $table->string('password');
            $table->string('type')->default('default');
            $table->enum('banido',['0','1'])->default(0);
            $table->ipAddress('ip');
            $table->timestamp('last_login');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
