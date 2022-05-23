<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;

class Question extends Model {
  use TakesSubmission;
  public $timestamps = false;
}
