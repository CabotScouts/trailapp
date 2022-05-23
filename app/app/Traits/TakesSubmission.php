<?php

namespace App\Traits;

use App\Models\Submission;

trait TakesSubmission {

  public function submissions() {
    return $this->hasMany(Submission::class);
  }

  public function accept($points) {
    $this->points = $points;
    $this->accepted = true;
    return $this->save();
  }

}
