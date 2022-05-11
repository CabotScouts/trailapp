<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Group;

return new class extends Migration {

  public function up() {
    Schema::create('teams', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->foreignIdFor(Group::class);
      $table->string('remember_token')->nullable();
    });
  }

  public function down() {
    Schema::dropIfExists('teams');
  }

};
