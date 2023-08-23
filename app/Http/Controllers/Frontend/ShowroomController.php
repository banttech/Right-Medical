<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShowroomController extends Controller
{
    public function profileInformation()
    {
        $pageTitle = 'Profile Information';
        $showroom = DB::table('showrooms')->where('user_id', Auth::user()->id)->first();
        return view('frontend.profiles.showroom_owner_profile', compact('pageTitle', 'showroom'));
    }
}