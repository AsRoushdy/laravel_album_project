<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Album extends Model
{
    protected $fillable = ['title'];

    public function pictures(){
        return $this->hasMany(Picture::class,'album_id');
    }
}
