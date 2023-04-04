<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
  
  protected $fillable = ['name', 'number'];
  public $timestamps = false;
  
  public function event() {
    return $this->hasOne(Event::class);
  }

  public function teams() {
    return $this->hasMany(Team::class);
  }
}
