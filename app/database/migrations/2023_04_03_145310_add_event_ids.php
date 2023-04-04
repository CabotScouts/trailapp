<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('event_id')->cascadeOnDelete()->nullable()->constrained();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('event_id')->cascadeOnDelete()->nullable()->constrained();
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreignId('event_id')->cascadeOnDelete()->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};
