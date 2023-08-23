<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',              
            ],[
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'password.required' => 'Password is required',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                if (Auth::user()->role == 'super_admin') {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Invalid Credentials');
                }else if(Auth::user()->status == 'inactive'){
                    Auth::logout();
                    return redirect()->back()->with('error', 'Your account is inactive');
                }else if(Auth::user()->role == 'showroom_owner'){
                    return redirect()->route('showroom_owner.service_requests');
                }else if(Auth::user()->role == 'sales_agent'){
                    return redirect()->route('sales_agent.service_requests');
                }
                else if(Auth::user()->role == 'service_engineer'){
                    return redirect()->route('service_engineer.service_requests');
                }
                // else {
                //     return redirect()->route('frontend.dashboard');
                // }
            } else {
                return redirect()->back()->with('error', 'Invalid Credentials');
            }
        }
        return view('frontend.login.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.home');
    }

    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        return view('frontend.dashboard.index', compact('pageTitle'));
    }

    public function recordAudio(Request $request)
    {
        $audio = $request->file('audio');
        $mime = $audio->getClientMimeType();
        $extension = $mime == 'audio/wav' ? 'wav' : 'mp3'; // set the appropriate extension based on mime type
        $filename = time() . '.' . $extension;
        $audio->move(public_path('voices'), $filename);
        return response()->json(['success' => true]);
    }
}
