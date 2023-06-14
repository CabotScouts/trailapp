<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use chillerlan\QRCode\{QRCode, QROptions};

class Team extends Authenticatable {

  public $fillable = ['name', 'group_id', 'join_token'];
  protected $hidden = ['remember_token', 'join_token'];
  protected $with = ['group'];

  public function group() {
    return $this->belongsTo(Group::class);
  }

  public function submissions() {
    return $this->hasMany(Submission::class);
  }

  public function getPointsAttribute() {
    return intval($this->submissions()->where('accepted', true)->sum('points'));
  }
  
  public function generateQR() {
    $options = new QROptions([
      'version' => 10,
      'imageTransparent' => false,
    ]);
    $qr = new QRCode($options);
    $url = route('join-team', ['id' => $this->id, 'code' => $this->join_token]);
    $qr->render($url, storage_path("app/qr/{$this->id}.png"));
  }

}
