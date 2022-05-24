<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Team;

Broadcast::channel("team.{team}", function($user, Team $team) {
  return $user->id === $team->id;
}, ['guards' => ['team']]);
