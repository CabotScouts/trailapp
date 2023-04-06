<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;
use App\Traits\EventSpecific;

class Challenge extends Model {
  
  use TakesSubmission, EventSpecific;
  protected $fillable = ['name', 'description', 'points'];
  public $timestamps = false;

}
