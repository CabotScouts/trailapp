<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TakesSubmission;

class Challenge extends Model {
  use TakesSubmission;
  protected $fillable = ['name', 'description', 'points'];
  public $timestamps = false;

  public function event() {
    return $this->hasOne(Event::class);
  }
}
