<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::table('submissions', function($table) {
      $table->softDeletes()->after('updated_at');
    });
  }


  public function down() {
    Schema::table('submissions', function($table) {
      $table->dropSoftDeletes();
    });
  }
};
