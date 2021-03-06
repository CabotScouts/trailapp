<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;

use App\Models\Upload;

class ProcessUpload implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $upload;
  
  public function __construct(Upload $upload) {
    $this->upload = $upload->withoutRelations();
  }

  public function handle() {
    $image = Image::make(Storage::path("public/uploads/0/{$this->upload->filename}"));
    $image = $image->orientate();
    $width = $image->width();
    $height = $image->height();
    
    $landscape = ($width > $height);
    
    if($landscape && $width > 1920) {
      $image = $image->resize(1920, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
    }
    else if($height > 1080) {
      $image = $image->resize(null, 1080, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
    }
    
    $image->save(Storage::path("public/uploads/1/{$this->upload->filename}"), 75);
    
    $this->upload->processed = true;
    $this->upload->save();
  }
}
