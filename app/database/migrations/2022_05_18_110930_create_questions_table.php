<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::create('questions', function (Blueprint $table) {
      $table->id();
      $table->integer('number')->default(1);
      $table->string('name');
      $table->string('question');
      $table->integer('points');
    });

    Schema::table('submissions', function (Blueprint $table) {
      $table->string('filename')->nullable()->change();
      $table->foreignId('question_id')->after('challenge_id')->nullable()->constrained()->onDelete('cascade');
    });
  }


  public function down() {
    Schema::table('submissions', function (Blueprint $table) {
      $table->string('filename')->nullable(false)->change();
      $table->dropForeign(['question_id']);
      $table->dropColumn(['question_id']);
    });

    Schema::dropIfExists('questions');
  }
};
