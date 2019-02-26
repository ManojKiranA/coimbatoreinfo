<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait TimeStampsTrait
{

 public static function boot()
  {
    parent::boot();
    // first we tell the model what to do on a creating event
    static::creating(function($modelName='')
    {
       $createdByColumnName = 'created_at';
      $modelName->$createdByColumnName = now();
    });
    // then we tell the model what to do on an updating event
    static::updating(function($modelName='')
    {
      $updatedByColumnName = 'updated_at';
      $modelName->$updatedByColumnName = now();
    });

    
  }
}
