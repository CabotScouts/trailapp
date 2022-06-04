<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Submission;
use App\Models\Upload;

return new class extends Migration {

  public function up() {
    Schema::create('uploads', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->foreignId('submission_id')->nullable()->constrained()->onDelete('set null'); // set id to NULL if submission is deleted
        $table->string('filename')->unique();
        $table->boolean('processed')->default(false);
    });
    
    Schema::table('submissions', function(Blueprint $table) {
      $table->foreignId('upload_id')->after('question_id')->nullable(); // don't allow submission to be deleted if upload exists
    });
    
    Storage::makeDirectory('public/uploads/0'); // unprocessed files
    Storage::makeDirectory('public/uploads/1'); // processed files
    
    $subs = Submission::whereNot('challenge_id', NULL)->get();
    foreach($subs as $sub) {
      $up = Upload::create(['submission_id' => $sub->id, 'filename' => $sub->filename]);
      $sub->upload_id = $up->id;
      $sub->save();
      
      Storage::move("public/uploads/$up->filename", "public/uploads/0/$up->filename"); // move into un-processed directory
    }
    
    Schema::table('submissions', function(Blueprint $table) {
      $table->dropColumn('filename');
    });
  }

  public function down() {
    Schema::table('submissions', function(Blueprint $table) {
      $table->string('filename')->after('question_id');
    });
    
    $ups = Upload::whereNot('submission_id', NULL)->get();
    foreach($ups as $up) {
      $sub = Submission::find($up->submission_id);
      $sub->filename = $up->filename;
      $sub->save();
      
      $dir = ($up->processed) ? "1" : "0";
      Storage::move("public/uploads/$dir/$up->filename", "public/uploads/$up->filename"); // move back into root upload directory
    }
    
    Storage::deleteDirectory('public/uploads/0');
    Storage::deleteDirectory('public/uploads/1');
    
    Schema::table('submissions', function(Blueprint $table) {
      $table->dropForeign(['upload_id']);
      $table->dropColumn(['upload_id']);
    });
    
    Schema::dropIfExists('uploads');
  }
};
