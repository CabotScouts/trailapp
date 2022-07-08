<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model {
  use SoftDeletes;

  protected $fillable = [ 'question_id', 'challenge_id', 'team_id', 'upload_id', 'answer' ];

  public function toArray() {
    return [
      'id' => $this->id,
      'upload' => ($this->upload) ? [ 'file' => $this->upload->file, 'link' => $this->upload->link ] : false,
      'answer' => ($this->answer) ? $this->answer : false,
      'challenge' => ($this->challenge) ? $this->challenge->name : false,
      'question' => ($this->question) ? ['name' => $this->question->name, 'text' => $this->question->question] : false,
      'time' => $this->time,
      'team' => $this->team->name,
      'group' => $this->team->group->name,
      'accepted' => $this->accepted,
    ];
  }

  public function challenge() {
    return $this->belongsTo(Challenge::class);
  }

  public function question() {
    return $this->belongsTo(Question::class);
  }

  public function team() {
    return $this->belongsTo(Team::class);
  }

  public function upload() {
    return $this->belongsTo(Upload::class);
  }

  public function getTimeAttribute() {
    $date = date_create($this->created_at);
    return date_format($date, "d/m/Y H:i");
  }

}
