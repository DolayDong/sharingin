<?php

namespace App\Http\Controllers\Api;

use App\Events\PesanBaru;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper;
use App\Models\Notifikasi;
use App\Models\Pesan;
use App\Models\User;
use App\Models\UsersData;
use App\Models\Teman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class UserController extends Controller
{


    public function users_data_()
    {
        return response(User::query()->get(["name", "email"]), 200);
    }

    public function index()
    {

        $bukanTeman = DB::select("SELECT user_2.name, user_2.id, photo_profile FROM users user_1,users user_2, users user_3 JOIN users_data ON users_data.user_id = user_3.id WHERE NOT EXISTS(SELECT " . Auth::id() . " FROM teman f WHERE f.user_id = user_1.id AND f.teman_id = user_2.id) AND NOT EXISTS(SELECT " . Auth::id() . " FROM teman f WHERE f.user_id = user_2.id AND f.teman_id = user_1.id) AND user_1.id != user_2.id AND user_1.id = " . Auth::id() . " GROUP BY `name`");


        if ($bukanTeman) {
            foreach ($bukanTeman as $key => $data) {
                $data->photo_profile = Helper::encodeUrl($data->photo_profile);
            }
        }


        return response()->json($bukanTeman);
    }

    public function user($user)
    {

        $datas = User::query()->where('name', '=', $user)->with(['postingans' => function($q) {
            $q->reorder('diunggah', 'desc')->with(['likes', 'comments']);
        }, 'postingans.postinganDetail', 'data'])->first();
        $apiData = $datas;

        if ($apiData->postingans) {
            foreach ($apiData->postingans as $key => $value) {
                $apiData->postingans[$key]->url_media = url(urlencode($value->url_media));
            }
        }

        return response()->json($apiData);
    }

    public function addTeman(User $user, Request $request)
    {

        $teman = auth()->user()->tambahTeman($user);

        if ($teman === NULL) {
            return response()->json(["pesan" => "anda sudah berteman", "teman" => $user->name], 400);
        }

        Teman::query()->create([
            "user_id" => $user->id,
            "teman_id" => Auth::id(),
            "berteman_pada" => time()
        ])->save();
        return response()->json(["pesan" => "berhasil ditambahkan", "teman" => $user->name], 200);
    }

    public function hapusTeman(User $user)
    {
        $teman = $user->berteman();

        if ($teman === null) {
            return response()->json(["pesan" => "anda tidak berteman"], 404);
        }

        $teman->delete();
        Teman::query()->where("teman_id", "=", Auth::id())->where("user_id", "=", $user->id)->delete();


        $data = User::query()->where("id", "=", $teman->teman_id)->get("name")->first();
        return response()->json(["pesan" => "anda sudah tidak berteman dengan", "teman" => $data], 200);
    }

    public function notifikasi_(User $user)
    {
        $notifikasi = $user->with(["notifications" => function ($q) {
            $q->reorder('dibuat_pada', 'desc')->with(["user" => function ($q) {
                $q->with("data");
            }, "postingan" => function ($q) {
                $q->with("postinganDetail");
            }]);
        }])->where("id", "=", $user->id)->first();



        if ($notifikasi) {
            foreach ($notifikasi->notifications as $data) {
                $data->user->data->photo_profile =  Helper::encodeUrl($data->user->data->photo_profile);;
                $data->postingan->url_media = Helper::encodeUrl($data->postingan->url_media);
            }
        }

        return response()->json($notifikasi);
    }

    public function kirim_pesan(Request $request)
    {

        $pesan = Pesan::query()->create([
            "user_id" => Auth::id(),
            "teman_id" => $request->teman_id,
            "text" => $request->pesan,
            "url_media" => $request->url_media,
            "dikirim_pada" => time(),
            "voice" => $request->voice
        ]);

        broadcast(new PesanBaru($pesan));
        if (!$pesan->save()) {
            return response()->json(["pesan" => "gagal rek"], 400);
        }

        return response()->json($pesan);
    }

    public function authPusher(Request $request)
    {
        $socketId = $request->socket_id;
        $namaChannel = $request->channel_name;


        $pusher = new Pusher('4c08e21f32b2ed3689f9', 'dd8b5fb305b7d81c6e6c', '1094155', [
            'cluster' => 'ap4',
            'useTLS' => true
        ]);

        $presence_data = ['name' => auth()->user()->name];
        $key = $pusher->presence_auth($namaChannel, $socketId, auth()->id(), $presence_data);
        return response($key);
    }

    public function cari__()
    {
        $bukanTeman = DB::select("SELECT user_2.name, user_2.id, photo_profile FROM users user_1,users user_2, users user_3 JOIN users_data ON users_data.user_id = user_3.id WHERE NOT EXISTS(SELECT 1 FROM teman f WHERE f.user_id = user_1.id AND f.teman_id = user_2.id) AND NOT EXISTS(SELECT 1 FROM teman f WHERE f.user_id = user_2.id AND f.teman_id = user_1.id) AND user_1.id != user_2.id AND user_1.id = 1 AND user_2.name LIKE '%" . request()->get('user') . "%' GROUP BY `name`");

        if ($bukanTeman) {
            foreach ($bukanTeman as $key => $data) {
                $data->photo_profile = Helper::encodeUrl($data->photo_profile);
            }
        }
        return response()->json($bukanTeman);
    }

    public function update_notifikasi_($id)
    {
        $update = Notifikasi::query()->where("postingan_id", "=", $id)->update(["dibaca" => 1]);
        if($update){
            return response()->json(["pesan" => "berhasil update"], 200);
        }
          
    }

    public function jumlah_notifikasi_()
    {
        $user = User::query()->where('api_token', '=', request()->get('api_token'))->first();
        $notifikasi = Notifikasi::query()->where("kepada", "=", $user->id)->where('dibaca', '=', 0)->get();
        return response()->json($notifikasi);

    }
}
