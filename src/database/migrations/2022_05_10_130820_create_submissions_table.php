<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Team;
use App\Models\Challenge;

return new class extends Migration {

  public function up() {
    Schema::create('submissions', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Team::class);
      $table->foreignIdFor(Challenge::class);
      $table->string('filename');
      $table->boolean('accepted');
    });
  }

  public function down() {
    Schema::dropIfExists('submissions');
  }

};
