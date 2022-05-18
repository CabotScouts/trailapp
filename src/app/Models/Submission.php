<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model {

  protected $fillable = [ 'challenge_id', 'team_id', 'filename' ];

  public function challenge() {
    return $this->belongsTo(Challenge::class);
  }

  public function question() {
    return $this->belongsTo(Question::class);
  }

  public function team() {
    return $this->belongsTo(Team::class);
  }

  public function getTimeAttribute() {
    $date = date_create($this->created_at);
    return date_format($date, "d/m/Y H:i");
  }

}
