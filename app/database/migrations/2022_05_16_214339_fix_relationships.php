<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Group;
use App\Models\Team;
use App\Models\Challenge;

return new class extends Migration {

  public function up() {
    // drop old...
    Schema::table('teams', function (Blueprint $table) {
      $table->dropColumn('group_id');
    });

    Schema::table('submissions', function (Blueprint $table) {
      $table->dropColumn(['team_id', 'challenge_id']);
    });

    // ...add new...
    Schema::table('teams', function (Blueprint $table) {
      $table->foreignId('group_id')->after('name')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('submissions', function (Blueprint $table) {
      $table->after('updated_at', function ($table) {
        $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('challenge_id')->nullable()->constrained()->onDelete('cascade');
      });
    });

    // ...now go fix test data
  }

  public function down() {
    Schema::table('teams', function (Blueprint $table) {
      $table->dropForeign(['group_id']);
      $table->dropColumn(['group_id']);
    });

    Schema::table('submissions', function (Blueprint $table) {
      $table->dropForeign(['team_id']);
      $table->dropForeign(['challenge_id']);
      $table->dropColumn(['team_id', 'challenge_id']);
    });

    Schema::table('teams', function (Blueprint $table) {
      $table->foreignIdFor(Group::class)->after('name');
    });

    Schema::table('submissions', function (Blueprint $table) {
      $table->after('updated_at', function ($table) {
        $table->foreignIdFor(Team::class);
        $table->foreignIdFor(Challenge::class);
      });
    });
  }

};
