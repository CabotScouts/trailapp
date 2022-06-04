<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Upload;

class PruneUploads implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable;

  public function handle() {
    $uploads = Upload::where('submission_id', NULL)->get();
    
    foreach($uploads as $upload) {
      $upload->removeFiles();
      $upload->delete();
    }
  }
  
}
