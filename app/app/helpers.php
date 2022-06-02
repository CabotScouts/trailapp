<?php

namespace App;

use Illuminate\Support\Str;

class Helpers {
  
  public static function points($points) {
    $label = Str::of('point')->plural($points);
    return "$points $label";
  }
  
}
