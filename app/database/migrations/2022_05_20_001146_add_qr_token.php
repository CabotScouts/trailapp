<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Team;

return new class extends Migration {

  public function up() {
    Schema::table('teams', function(Blueprint $table) {
      $table->string('join_token')->nullable()->after('group_id');
    });

    Storage::makeDirectory('qr');

    $teams = Team::all();
    foreach($teams as $team) {
      $team->join_token = Str::random(100);
      $team->save();

      $team->generateQR();
    }
  }

  public function down() {
    Schema::table('teams', function(Blueprint $table) {
      $table->dropColumn('join_token');
    });

    Storage::deleteDirectory('qr');
  }

};
