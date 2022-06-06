<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

Artisan::command("user:make {username?} {--random}", function ($username=false, $random=false) {
  $u = $username ? $username : $this->ask("Enter a username");
  $p = $random ? Str::random(10) : $this->secret("Enter a password") ;

  User::create([
    'username' => $u,
    'password' => Hash::make($p),
  ]);

  if($random) {
    $this->info("Created new user {$u} with password {$p}");
  }
  else {
    $this->info("Created new user {$u}");
  }
});
