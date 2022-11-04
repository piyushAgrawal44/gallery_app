<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageTypes extends Model
{
    protected $table="image_types";
    protected $fillable = [ 'user_id','type'];
}
