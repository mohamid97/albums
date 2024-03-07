<?php

namespace App\Models\Albums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    public function images(){
        return $this->hasMany(AlbumImage::class , 'album_id');
    }
}
