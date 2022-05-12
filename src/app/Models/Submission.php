<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model {

  public $fillable = [ 'challenge_id', 'team_id', 'filename' ];

  public function challenge() {
    return $this->hasOne(Challenge::class);
  }

  public function team() {
    return $this->hasOne(Team::class);
  }

}
