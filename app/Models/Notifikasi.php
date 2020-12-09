<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $fillable = ["kepada", "dari", "postingan_id", "dibuat_pada", "type", "dibaca"];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, "dari", "id");
    }

    public function postingan()
    {
        return $this->belongsTo(Postingan::class);
    }
}
