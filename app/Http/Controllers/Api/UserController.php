<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersData;
use App\Models\Teman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function users_data_()
    {
        return response(User::query()->get(["name", "email"]), 200);
    }

   public function index(Request $request)
   {

    $bukanTeman = DB::select("SELECT user_2.name, user_2.id, photo_profile FROM users user_1,users user_2, users user_3 JOIN users_data ON users_data.user_id = user_3.id WHERE NOT EXISTS(SELECT ". Auth::id() ." FROM teman f WHERE f.user_id = user_1.id AND f.teman_id = user_2.id) AND NOT EXISTS(SELECT " . Auth::id() . " FROM teman f WHERE f.user_id = user_2.id AND f.teman_id = user_1.id) AND user_1.id != user_2.id AND user_1.id = ". Auth::id() ." GROUP BY `name`");


    if($bukanTeman){
        foreach ($bukanTeman as $key => $data) {
            $data->photo_profile[$key] = urlencode($data->photo_profile);
        }
    }
    return response()->json($bukanTeman);
 
   }

   public function user($user)
   {

    $datas = User::query()->where('name', '=', $user)->with(['postingans','postingans.postinganDetail', 'data'])->first();
    $apiData = $datas;

    if($apiData->postingans){
        foreach ($apiData->postingans as $key => $value) {
            // echo $key;
            $apiData->postingans[$key]->url_media = url(urlencode($value->url_media));
            // echo $value->url_media;
        }
    }

    return response()->json($apiData);
   }

   public function addTeman(User $user, Request $request)
   {

       $teman = auth()->user()->tambahTeman($user);
    //    $namaUser = $dataTeman->user;

       if($teman === NULL){
           return response()->json(["pesan" => "anda sudah berteman", "teman" => $user->name], 400);
       }

       return response()->json(["pesan" => "berhasil ditambahkan", "teman" => $user->name], 200);
   }

   public function hapusTeman(User $user)
   {
       $teman = $user->berteman();

       if($teman === null){
           return response()->json(["pesan" => "anda tidak berteman"], 404);
       }

       $teman->delete();

       $data = User::query()->where("id", "=", $teman->teman_id)->get("name")->first();
       return response()->json(["pesan" => "anda sudah tidak berteman dengan", "teman" => $data], 200);
   }
}
