<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ["user_id", "teman_id", "text", "url_media", "dikirim_pada", "voice"];
    public $timestamps = false;
}
