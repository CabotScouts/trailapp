<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
  protected $fillable = ['submission_id', 'filename'];

  public function submission() {
    return $this->belongsTo(Submission::class);
  }

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
  
  protected function getLinkAttribute() {
    return url("storage/uploads/0/$this->filename");
  }
  
  public function removeFiles() {
    $success = Storage::delete("public/uploads/0/$this->filename");
    
    if($this->processed) {
      $success &= Storage::delete("public/uploads/1/$this->filename");
    }
    
    return $success;
  }
}
