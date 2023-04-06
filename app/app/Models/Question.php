<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;
use App\Traits\EventSpecific;

class Question extends Model {

  use TakesSubmission, EventSpecific;
  protected $fillable = ['number', 'name', 'question', 'points'];
  public $timestamps = false;
  
}
