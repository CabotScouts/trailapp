<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessageToTeams implements ShouldBroadcast {
  use Dispatchable, InteractsWithSockets;

  public $team;
  public $message;

  public function __construct($message, $team = false) {
    $this->message = $message;
    $this->team = $team;
  }

  public function broadcastOn() {
    if($this->team !== false) {
      return new PrivateChannel("team.{$this->team}");
    }
    else {
      return new Channel("global");
    }
  }
}
