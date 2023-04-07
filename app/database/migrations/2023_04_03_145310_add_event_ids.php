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
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
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

        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};
