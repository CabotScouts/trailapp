<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;

class Challenge extends Model {
  use TakesSubmission;
  public $timestamps = false;

  public function event() {
    return $this->hasOne(Event::class);
  }
}
