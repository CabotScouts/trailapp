<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Submission;

class SubmissionAccepted implements ShouldBroadcast {
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $submission;

  public function __construct(Submission $submission) {
    $this->submission = $submission;
  }

  public function broadcastOn() {
    return new PrivateChannel("team.{$this->submission->team->id}");
  }
  
  public function broadcastWith() {
    $type = ($this->submission->challenge_id === null) ? "answer" : "photo";
    $name = ($this->submission->challenge_id === null) ? $this->submission->question->name : $this->submission->challenge->name;
    return ['type' => $type, 'name' => $name];
  }
}
