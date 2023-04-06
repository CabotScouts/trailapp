<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;

class Question extends Model {
  use TakesSubmission;
  protected $fillable = ['number', 'name', 'question', 'points'];
  public $timestamps = false;

  public function event() {
    return $this->hasOne(Event::class);
  }
}
