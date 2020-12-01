<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersData extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "photo_profile", "pekerjaan", "tentang"];
    public $timestamps = false;
    protected $table = "users_data";


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
