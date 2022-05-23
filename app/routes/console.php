<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

Artisan::command("user:make {username} {--password}", function ($username, $password=false) {
  $p = $password ? $this->secret("Enter a password") : Str::random(10);

  User::create([
    'username' => $username,
    'password' => Hash::make($p),
  ]);

  if($password) {
      $this->info("Created new user {$username}");
  }
  else {
      $this->info("Created new user {$username} with password {$p}");
  }
});
