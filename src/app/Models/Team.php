<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Team extends Authenticatable {

  public $fillable = ['name', 'group_id'];
  protected $hidden = ['remember_token'];

  public function group() {
    return $this->belongsTo(Group::class);
  }

  public function submissions() {
    return $this->hasMany(Submission::class);
  }
  
  protected function getPointsAttribute() {
    return $this->submissions()->where('accepted', true)->join('challenges', 'challenges.id', '=', 'submissions.challenge_id')->sum('challenges.points');
  }

}
