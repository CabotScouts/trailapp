<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOldUploads implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable;

  public function handle() {
    $uploads = Upload::where('processed', false)->get();
    
    foreach($uploads as $upload) {
      ProcessUpload::dispatch($upload);
    }
  }
}
