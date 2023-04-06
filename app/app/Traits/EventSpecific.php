<?php

namespace App\Traits;

use App\Helpers;
use App\Models\Event;

trait EventSpecific {

  public function event() {
    return $this->hasOne(Event::class);
  }
  
}
