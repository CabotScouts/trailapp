<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Submission;

class PruneSubmissions implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable;

  public function handle() {
    $submissions = Submission::onlyTrashed()->get();
    
    foreach($submissions as $submission) {
      $submission->forceDelete();
    }
  }
  
}
