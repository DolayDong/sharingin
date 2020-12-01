<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
