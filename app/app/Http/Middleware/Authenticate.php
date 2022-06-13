<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {

  protected function redirectTo($request) {
    if($request->is("dashboard*")) {
      return route('login');
    }
    else {
      return route('start');
    }
  }

}
