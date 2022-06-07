<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;

Artisan::command("user:make {username?} {--password=} {--random}", function ($username=false, $password=false, $random=false) {
  $u = $username ? $username : $this->ask("Enter a username");
  $p = $password ? $password : ($random ? Str::random(10) : $this->secret("Enter a password"));

  $validator = Validator::make(
    ['username' => $u, 'password' => $p],
    ['username' => 'required|unique:users', 'password' => 'required|min:8']
  );

  if($validator->fails()) {
    foreach($validator->errors()->all() as $error);
    $this->error($error);
  }
  else {
    $data = $validator->validated();
    User::create($data);

    if($random) {
      $this->info("Created new user {$u} with password {$p}");
    }
    else {
      $this->info("Created new user {$u}");
    }
  }
});
