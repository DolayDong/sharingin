<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = new User();
        $datauser = $user->query()->where('id', '=', Auth::id())->with('data')->first();
        return view('app.home_', ["userdata" => $datauser]);
    }
}
