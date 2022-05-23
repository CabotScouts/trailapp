<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string('username');
      $table->string('password');
      $table->string('remember_token')->nullable();
    });
  }


  public function down() {
    Schema::dropIfExists('users');
  }
};
