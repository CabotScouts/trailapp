<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::table('submissions', function (Blueprint $table) {
      $table->text('answer')->after('filename')->nullable();
      $table->integer('points')->after('accepted')->nullable();
    });
  }

  public function down() {
    Schema::table('submissions', function (Blueprint $table) {
      $table->dropColumn('answer');
      $table->dropColumn('points');
    });
  }

};
