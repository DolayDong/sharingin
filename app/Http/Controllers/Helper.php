<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\matches;

class Helper {
     public static function kirim_email(Request $request, $buat, $token){
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
         $namaBaru = base64_encode(random_bytes(8));
         if($request->post("gambar")){
            $namaBaru = str_replace("/", "S", $namaBaru) . "." . $request->file("gambar-post")->extension();
               if(!in_array($request->file("gambar-post")->extension(), ["png", "jpg", "jpeg", "JPEG", "PNG", "JPG"])){
                   return response()->json(["message" => "gagal", "url" => null], 400);
                } else {
                    $request->file("gambar-post")->storeAs("/public/temp_image_post/", $namaBaru);
                    return response()->json(["message" => "berhasil", "url" => "storage/temp_image_post/" . $namaBaru], 200);
                }

            } else if($request->post("video")) {
                $namaBaru = str_replace("/", "S", $namaBaru) . "." . $request->file("video-post")->extension();
               if(!in_array($request->file("video-post")->extension(), ["mp4", "mpeg", "MPEG", "MP4"])){
                   return response()->json(["message" => "gagal", "url" => null], 400);
                } else {
                    $request->file("video-post")->storeAs("/public/temp_video_post/", $namaBaru);
                    return response()->json(["message" => "berhasil", "url" => "storage/temp_video_post/" . $namaBaru], 200);
                }
            }
     }
 }
 
 
 
 
 ?>