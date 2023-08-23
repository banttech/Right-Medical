<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     $pageTitle = 'Dashboard';
    //     return view('admin.dashboard.index', compact('pageTitle'));
    // }

    public function manageProfile()
    {
        $pageTitle = 'Manage Profile';
        $superAdmin = DB::table('users')->where('id', auth()->user()->id)->first();

        return view('admin.dashboard.manage_profile', compact('pageTitle', 'superAdmin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;

        $superAdmin = DB::table('users')->where('id', auth()->user()->id)->first();

        if (Hash::check($oldPassword, $superAdmin->password)) {
            DB::table('users')->where('id', auth()->user()->id)->update([
                'password' => Hash::make($newPassword),
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'Old password is incorrect');
        }
    }
}
