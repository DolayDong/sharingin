<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Postingan;
use App\Models\PostinganDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\matches;

class Helper
{
    public static function kirim_email(Request $request, $buat, $token)
    {
        $email = $request->email;
        //data untuk di kirim kedalam template email
        $data = [
            'username' => $request->username,
            'appname' => env('APP_NAME'),
            'email' => $email,
            'token' => urlencode($token)
        ];

        if ($buat == 'verifikasi') {
            Mail::send('template.email_template', $data, function ($mail) use ($email) {
                $mail->to($email, 'no-reply')->subject('Aktivasi Akun');
                $mail->from(env('MAIL_USERNAME'), 'TEAM KKI KELOMPOK VI');
            });
        }

        if (Mail::failures()) {
            return false;
        }
        return true;
    }

    public function file_validasi(Request $request)
    {
        $namaBaru = time();
        if ($request->post("gambar")) {
            $namaBaru = $namaBaru . "_" . time() . "." . $request->file("gambar-post")->extension();
            if (!in_array($request->file("gambar-post")->extension(), ["png", "jpg", "jpeg", "JPEG", "PNG", "JPG"])) {
                return response()->json(["message" => "gagal", "url" => null], 400);
            } else {
                $request->file("gambar-post")->storeAs("/public/temp_image_post/", $namaBaru);
                return response()->json(["message" => "berhasil", "url" => "storage/temp_image_post/" . $namaBaru], 200);
            }
        } else if ($request->post("video")) {
            $namaBaru = $namaBaru . "_" . time() . "." . $request->file("video-post")->extension();
            if (!in_array($request->file("video-post")->extension(), ["mp4", "mpeg", "MPEG", "MP4"])) {
                return response()->json(["message" => "gagal", "url" => null], 400);
            } else {
                $request->file("video-post")->storeAs("/public/temp_video_post/", $namaBaru);
                return response()->json(["message" => "berhasil", "url" => "storage/temp_video_post/" . $namaBaru], 200);
            }
        }
    }

    public static function inputNotifikasi(Postingan $postingan, $type, $userTarget)
    {

        $notifikasi = Notifikasi::query()->create([
            // 0 type sebagai like
            "type" => $type,
            "postingan_id" => $postingan->id,
            "kepada" => $postingan->user_id,
            "dari" => $userTarget,
            "dibuat_pada" => time()
        ]);

        if (!$notifikasi) {
            return NULL;
        }

        return $notifikasi;
    }

    public static function encodeUrl($urlMentah)
    {
        $url = rawurlencode($urlMentah);
        $url = str_replace('%3A', ':', str_replace('%2F', '/', $url));

        return $url;
    }
}
