<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessageToTeams implements ShouldBroadcast {
  use Dispatchable, InteractsWithSockets;

  public $message;

  public function __construct($message) {
    $this->message = $message;
  }

  public function broadcastOn() {
    return new Channel("global");
  }
}
