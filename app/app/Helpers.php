<?php

namespace App;

use Illuminate\Support\Str;

class Helpers {
  
  public static function points($points) {
    $label = ($points == 0 || abs($points) > 0) ? __("points") : __("point");
    return "$points $label";
  }
  
}
