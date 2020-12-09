<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function komentari_(Request $request, Postingan $postingan)
    {
        $commentar = $postingan->comments()->create([
            "user_id" => $request->user_id,
            "body" => $request->body,
            "dibuat" => time(),
            "postingan_id" => $postingan->id
        ]);

        Helper::inputNotifikasi($postingan, 1, $postingan->user_id);
        $commentar = Comment::query()->where("id", "=", $commentar->id)->with(["user" => function ($q) {
            $q->with("data");
        }])->first();
        return $commentar->toJson();
    }

    public function komentar_(Postingan $postingan)
    {
        $data = $postingan->comments()->with(["user" => function ($q) {
            $q->with("data");
        }])->get();
        return response()->json($data);
    }
}
