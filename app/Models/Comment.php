<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ["body", "user_id", "postingan_id", "dibuat"];
    public $timestamps = false;

    public function postingans()
    {
        return $this->belongsTo(Postingan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
