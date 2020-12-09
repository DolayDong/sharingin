<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper;
use App\Models\Like;
use App\Models\Notifikasi;
use App\Models\Postingan;
use App\Models\PostinganDetail;
use App\Models\Teman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class PostinganController extends Controller
{

    public function postingan_teman(Request $request)
    {
        if ($request->header("API_TOKEN")) {
            // return User::query()->where(
            //     'api_token', '=', $request->header('API_TOKEN')
            //     )->with(
            //         ['data', 'temans' => function($query){
            //     $query->with(
            //         ['postingans', 'postingan' => function($query){
            //         $query->with(["postinganDetail", "user"]);
            //     }]
            // );
            // }])->first();

            // return User::with(['temans','postingans' => function($query) {
            //     $query->with(["postinganDetail", "user" => function($query){
            //         $query->with("data");
            //     }]);
            // }])->get();

            $user = User::query()->where("api_token", "=", $request->header("API_TOKEN"))->get()->first();
            $temans = Teman::with(["postingans" => function ($query) {
                $query->reorder("diunggah", "desc")->with(["postinganDetail", "user" => function ($query) {
                    $query->with("data");
                }, "likes", "comments"]);
            }])->where("user_id", "=", $user->id)->get();


            if ($temans) {
                foreach ($temans as $kunci => $teman) {
                    foreach ($teman->postingans as $key => $postingan) {
                        $postingan->url_media = urlencode($postingan->url_media);
                    }
                }
            }

            return $temans;
        } else {
            return response()->json(["pesan" => "endi tokene rek?"], 401);
        }
    }
    public function post_(Request $request)
    {
        if (!empty($request->post("__type"))) {
            if ($request->post("__type") === "foto") {
                $urlTempPreviewImage = $request->post("temp_image");
                $arrTmp = explode("/", $urlTempPreviewImage);
                unset($arrTmp[0]);

                $url = implode("/", $arrTmp);

                if (Storage::delete("public/" . $url)) {
                    $namaBaru = time() . "_." . $request->file("gambar-post")->extension();
                    $path = $request->file("gambar-post")->storeAs("/public/images/posts", $namaBaru);
                    // $request->file("gambar-post")->move(public_path('images/posts'), $namaBaru);

                    $path = str_replace('public', '/storage', $path);


                    $postingan = Postingan::query()->create([
                        // type 0 untuk gambar
                        "type" => 0,
                        "user_id" => $request->post("user_id"),
                        "url_media" => $path,
                        "diunggah" => time()
                    ]);

                    if ($postingan->save()) {
                        $detailPostingan = PostinganDetail::query()->create([
                            "postingan_id" => $postingan->id,
                            "nama_file" => $request->file("gambar-post")->getClientOriginalName(),
                            "ukuran_file" => $request->file("gambar-post")->getSize(),
                            "caption" => $request->post("caption-gambar")
                        ]);

                        if ($detailPostingan->save()) {
                            return response()->json(["message" => "Berhasil"], 200);
                        } else {
                            return response()->json(["message" => "Gagal di detail"], 500);
                        }
                    } else {

                        return response()->json(["message" => "Gagal di postingan"], 500);
                    }
                } else {
                    return response()->json(["pesan" => "ga ada temporarry"], 500);
                }
            } else if ($request->post("__type") === "video") {
                $urlTempVideo = $request->post("temp_video");
                $arrTmp = explode("/", $urlTempVideo);
                unset($arrTmp[0]);

                $url = implode("/", $arrTmp);

                if (Storage::delete("public/" . $url)) {
                    $namaBaru = time() . "_." . $request->file("video-post")->extension();
                    $path = $request->file("video-post")->storeAs("/public/videos/posts", $namaBaru);
                    // $request->file("gambar-post")->move(public_path('videos/posts'), $namaBaru);

                    $path = str_replace('public', '/storage', $path);


                    $postingan = Postingan::query()->create([
                        // type 2 untuk video
                        "type" => 2,
                        "user_id" => $request->post("user_id"),
                        "url_media" => $path,
                        "diunggah" => time()
                    ]);

                    if ($postingan->save()) {
                        $detailPostingan = PostinganDetail::query()->create([
                            "postingan_id" => $postingan->id,
                            "nama_file" => $request->file("video-post")->getClientOriginalName(),
                            "ukuran_file" => $request->file("video-post")->getSize(),
                            "caption" => $request->post("caption-video")
                        ]);

                        if ($detailPostingan->save()) {
                            return response()->json(["message" => "Berhasil"], 200);
                        } else {
                            return response()->json(["message" => "Gagal di detail"], 500);
                        }
                    } else {

                        return response()->json(["message" => "Gagal di postingan"], 500);
                    }
                } else {
                    return response()->json(["pesan" => "ga ada temporarry"], 500);
                }
            } else if ($request->post("__type") === "status") {
                $postingan = Postingan::query()->create([
                    // type 2 untuk video
                    "type" => 1,
                    "user_id" => $request->post("user_id"),
                    "url_media" => NULL,
                    "diunggah" => time()
                ]);

                if ($postingan->save()) {
                    $detailPostingan = PostinganDetail::query()->create([
                        "postingan_id" => $postingan->id,
                        "nama_file" => NULL,
                        "caption" => $request->post("status")
                    ]);

                    if ($detailPostingan->save()) {
                        return response()->json(["message" => "Berhasil"], 200);
                    }
                } else {
                    return response()->json(["pesan" => "mohon maaf, sedang ada gangguan pada server"], 500);
                }
            }
        }
    }

    public function like(Postingan $postingan)
    {
        if (request()->header("API_KEY")) {
            $like = Like::query()->create([
                "postingan_id" => $postingan->id,
                "user_id" => request()->post("idGw"),
                "disukai_pada" => time()
            ]);

            if ($like->save()) {
                $user = User::query()->where("id", "=", $postingan->user_id)->get()->first();
                // type 0 untuk like
                $notifikasiLike = Helper::inputNotifikasi($postingan, 0, request()->post("idGw"));

                if ($notifikasiLike->save()) {

                    return response()->json(["pesan" => "anda menambahkan like pada postingan", "user" => $user->name]);
                }
            } else {
                return response()->json(["pesan" => "server error"], 500);
            }
        } else {
            return response()->json(["pesan" => "endi tokenne rwk?"], 400);
        }
    }

    public function dislike(Postingan $postingan)
    {
        if (request()->header("API_KEY")) {
            $like = Like::query()->where("postingan_id", "=", $postingan->id);

            if ($like->delete()) {
                return response()->json(["pesan" => "anda tidak menyukai postingan ", "user" => User::query()->where("id", "=", $postingan->user_id)->get("name")->first()]);
            } else {
                return response()->json(["pesan" => "server error"], 500);
            }
        } else {
            return response()->json(["pesan" => "endi tokenne rwk?"], 400);
        }
    }

    public function detail_post(Postingan $postingan)
    {
        $postingan = $postingan->with(["postinganDetail", "user" => function ($q) {
            $q->with("data");
        }, "likes" => function ($q) {
            $q->get();
        }])->where("id", "=", $postingan->id)->first();


        $postingan->user->data->photo_profile = Helper::encodeUrl($postingan->user->data->photo_profile);

        return response()->json($postingan);
    }
}
