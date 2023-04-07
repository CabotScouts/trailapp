<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'active'];
    public $timestamps = false;

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function challenges() {
        return $this->hasMany(Challenge::class);
    }

    public function groups() {
        return $this->hasMany(Group::class);
    }

    public function teams() {
        return $this->hasMany(Team::class);
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

}
