<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Upload extends Model
{
  protected $fillable = ['submission_id', 'filename'];

  protected function fromFile(UploadedFile $photo, $id) {
    $ext = $photo->extension();
    $filename = strval(Auth::user()->id) . "_" . $id . "_" . Str::random(15) . "." . $ext;
    $photo->storeAs("public/uploads/0/", $filename);
    
    return $this->create(['filename' => $filename]);
  }

  protected function getFileAttribute() {
    $dir = $this->processed ? "1" : "0";
    return url("storage/uploads/$dir/$this->filename");
  }
}
