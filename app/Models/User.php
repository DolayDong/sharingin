<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'aktif',
        'api_token',
        'email_verivied_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

     public function data()
     {
        return $this->hasOne(UsersData::class);
     }

     public function postingans()
     {
        return $this->hasMany(Postingan::class, "user_id", "id");
     }

     public function temans()
     {
         return $this->hasMany(Teman::class);
     }

     public function teman()
     {
         return $this->hasOne(Teman::class,'teman_id', 'id')->where('user_id', '=', Auth::id());
     }
     public function tambahTeman(User $user)
     {
         if($this->temans()->where('teman_id', '=', $user->id)->first()){
             return NULL;
         }

         return $this->temans()->save(new Teman([
             'user_id' => Auth::id(),
             'teman_id' => $user->id,
             'berteman_pada' => time()
         ]));
     }

     public function berteman()
     {
        return Teman::query()->where('user_id', '=', Auth::id())->where('teman_id', '=', $this->id)->first();
     }


}
