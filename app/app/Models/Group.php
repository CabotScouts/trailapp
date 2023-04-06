<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\EventSpecific;

class Group extends Model {

  use EventSpecific;
  protected $fillable = ['name', 'number'];
  public $timestamps = false;

  public function teams() {
    return $this->hasMany(Team::class);
  }

}
