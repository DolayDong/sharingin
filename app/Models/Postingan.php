<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostinganDetail;

class Postingan extends Model
{
    use HasFactory;
    protected $fillable = ["type", "user_id", "url_media", "diunggah"];
    public $timestamps = false;

    public function postinganDetail()
    {
        return $this->hasOne(PostinganDetail::class, 'postingan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function teman()
    {
        return $this->hasMany(Teman::class, "user_id", "teman_id");
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function notifikasi()
    {
        return $this->belongsTo(Notifikasi::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
