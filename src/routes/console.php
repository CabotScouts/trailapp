<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

Artisan::command('user:make {username}', function ($username) {
  $password = Str::random(10);
  
  User::create([
    'username' => $username,
    'password' => Hash::make($password),
  ]);
  
  $this->info("Created new user {$username} with password {$password}");
});
