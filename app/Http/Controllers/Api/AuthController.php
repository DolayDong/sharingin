<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Session;
use App\Http\Controllers\Helper;
use App\Models\UsersData;

class AuthController extends Controller
{
    public function registrasi_(Request $request)
    {
        if($request->hasHeader("X-CSRF-TOKEN")){
            // replace karakter spasi pada username menjadi titik
        $username = str_replace(" ", ".", $request->post('nama'));

        // cek apakah username sudah terdaftar
        if (User::query()->where('name', '=', $username)->first()) {
            // jika sudah return response ke api
            return response()->json(["message" => "username sudah terdaftar", "error" => "username"], 400);
        } else {
            // cek email apakah sudah terdaftar
            if (User::query()->where('email', '=', $request->only("email"))->first()) {
                // kirim response 400 ke request jika sudah
                return response()->json(["message" => "email sudah terdaftar", "error" => "email"], 400);
            } else {
                // data user dan token aktivasi
                $tokenverivikasi = base64_encode(random_bytes(64));
                $apitoken = base64_encode(random_bytes(32));
                $email = $request->post('email');

                // EloquentOrm laravel
                $datauser = User::query()->create([
                    'name' => strtolower($username),
                    'email' => $email,
                    'api_token' => $apitoken,
                    'password' => Hash::make($request->post('password-konfirmasi'))
                ]);

                // EloquentOrm laravel
                $datatoken = Token::query()->create([
                    'email' => $email,
                    'token' => $tokenverivikasi,
                    'dibuat' => time()
                ]);

                // jika datauser berhasil disimpan ke database
                if ($datauser->save()) {
                    // cek datatoken juga
                    if ($datatoken->save()) {

                        // cek apakah send email berhasil?
                        if (Helper::kirim_email($request, "verifikasi", $tokenverivikasi)) {
                            // masukkan data tambahan untuk user 
                            $iduser = User::query()->where('name', '=', strtolower($username))->where('email', '=', $email)->get(["id"])->first()->id;
                            
                            if(UsersData::query()->create([
                                'user_id' => $iduser
                            ])->save()){
                                // jika berhasil kirim response ke request kode 200
                                return response()->json(["message" => "email verifikasi telah dikirim"], 200);
                            }
                        } else {
                            return response()->json(["message" => "gagal mengirim email verifikasi"], 500);
                        }
                    }
                }
            }
        }
        } else {
            return response(["pesan" => "ndi tokene rek?"], 500);
        }
    }

    public function verifikasi(Request $request)
    {
        // ambil data email dan token dari url
        $emailurl = $request->get('email');
        $tokenurl = $request->get('token');

        // cek apakah email dan token ada di database, untuk mencegah user menulis manual email dan token
        $datatoken = Token::query()->where('email', '=', $emailurl);
        if ($datatoken->first()) {
            // cek token
            if ($datatoken->first()->token === $tokenurl) {

                // cek waktu kadaluwarsa
                if (time() - $datatoken->first()->dibuat < (60 * 45)) {
                    // hapus data token 
                    if ($datatoken->where('token', '=', $tokenurl)->delete()) {
                        // update data verivikasi email dan status aktif
                        if (User::query()->where('email', '=', $emailurl)->update(['email_verivied_at' => time(), "aktif" => 1])) {
                            Auth::logout();
                            return view('template.valid_', ["email" => $emailurl]);
                        }
                    }
                } else {
                    // jika kadaluwarsa, hapus data token
                    if ($datatoken->where('token', '=', $tokenurl)->delete()) {
                        // lalu hapus data user
                        if (User::query()->where('email', '=', $emailurl)->delete()) {
                            // setelah berhasil dihapus, tampilkan view
                            return view('template.tidak_valid_verifikasi', ["code" => 404, "pesan" => "maaf! token kadaluwarsa, harap daftarkan email anda kembali", "judul" => "Bad Request"]);
                        }
                    }
                }
            } else {
                return view('template.tidak_valid_verifikasi', ["code" => 400, "pesan" => "token tidak valid", "judul" => "Bad Request"]);
            }
        } else {
            return view('template.tidak_valid_verifikasi', ["code" => 400, "pesan" => "email belum terdaftar", "judul" => "Bad Request"]);
        }
    }

    public function login(Request $request)
    {
        $username = $request->post('emailLogin');
        $password = $request->post('passwordLogin');
        $remember = false;

        if ($request->rememberme === "on") {
            $remember = true;
        }

        $user = User::query()->where('email', '=', $username)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                if ($user->aktif === 1) {
                    if (Auth::attempt(['email' => $username, 'password' => $password, 'aktif' => 1], $remember)) {
                        // data untuk sessi
                        $sessi = Session::query()->create([
                            'user_id' => Auth::id(),
                            'user_agent' => $request->userAgent(),
                            'aktifitas_terakhir' => time()
                        ]);
                        if ($sessi->save()){
                            return response()->json(["pesan" => "success", "token"], 200);
                        }
                    }
                } else {
                    // user belum di aktivasi
                    return response()->json(["pesan" => "harap aktivasi akun anda"], 400);
                }
            } else {
                // password salah
                return response()->json(["pesan" => "password salah"], 400);
            }
        } else {
            // user tidak ada
            return response()->json(["pesan" => "username belum terdaftar"], 400);
        }
    }

    public function logout()
    {
        $sessi = Session::query()->where('user_id', '=', Auth::id());
            Auth::logout();
            if($sessi->delete()){
                request()->session()->flush();
                return redirect()->route('login');
            } 

    }
    

}
