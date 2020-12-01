<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teman extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "teman_id", "berteman_pada"];
    protected $table = "teman";
    public $timestamps = false;


    public function teman()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'user_id', 'id');
    }

    public function postingans()
    {
        return $this->hasMany(Postingan::class, "user_id", "teman_id");
    }

}
