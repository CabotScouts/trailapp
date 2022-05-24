<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateRedis implements ShouldBroadcast {
  use Dispatchable, InteractsWithSockets;

  public $message;

  public function __construct($message) {
    $this->message = $message;
  }

  public function broadcastOn() {
    return new Channel('global');
  }
}
