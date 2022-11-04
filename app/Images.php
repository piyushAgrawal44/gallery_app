<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table="images";
    protected $fillable = [ 'image_url','type','qr_code','user_id'];
}
