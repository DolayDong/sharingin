<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use App\Models\Teman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemanController extends Controller
{
    public function temans()
    {
        $user = User::query()->where("api_token", "=", request()->get("api_token"))->first();

        $temans = Teman::with(["teman" => function ($q) {
            $q->with("data");
        }])->where("user_id", "=", $user->id)->get();



        return response()->json($temans, 200);
    }

    public function ambil_pesan_dengan($id)
    {
        $pesans = Pesan::query()->where("user_id", "=", $id)->orWhere("teman_id", "=", $id)->get();
        return response()->json($pesans);
    }
}
