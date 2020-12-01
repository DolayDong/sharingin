<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostinganDetail extends Model
{
    use HasFactory;
    protected $fillable = ["postingan_id", "nama_file", "ukuran_file", "caption"];
    public $timestamps = false;

    public function detail()
    {
        return $this->belongsTo(Postingan::class);
    }
}
