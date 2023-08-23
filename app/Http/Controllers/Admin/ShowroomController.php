<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShowroomController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Surgical Showrooms';
        if ($request->has('search')) {
            $showrooms = DB::table('showrooms')
                ->where('showroom_name', 'like', '%' . $request->search . '%')
                ->orWhere('contact_name', 'like', '%' . $request->search . '%')
                ->orWhere('contact_number', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%')
                ->paginate(50);
        } else {
            $showrooms = DB::table('showrooms')->paginate(50);
        }

        return view('admin.showrooms.index', compact('pageTitle', 'showrooms'));
    }

    public function addShowroom()
    {
        $pageTitle = 'Add Surgical Showroom';
        return view('admin.showrooms.create', compact('pageTitle'));
    }

    public function createShowroom(Request $request)
    {
        $request->validate([
            'showroom_name' => 'required',
            'whatsapp_number' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'email' => 'required|email|unique:users',
            'u_password' => 'required',
            'confirm_password' => 'required|same:u_password',
            'status' => 'required',
        ], [
            'showroom_name.required' => 'Showroom name is required',
            'whatsapp_number.required' => 'Whatsapp number is required',
            'contact_name.required' => 'Contact name is required',
            'contact_number.required' => 'Contact number is required',
            'address.required' => 'Location is required',
            'country.required' => 'Country is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'u_password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Confirm password must be same as password',
            'status.required' => 'Status is required',
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => $request->contact_name,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'role' => 'showroom_owner',
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $showroom = DB::table('showrooms')->insert([
            'user_id' => $userId,
            'showroom_name' => $request->showroom_name,
            'whatsapp_number' => $request->whatsapp_number,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'simple_password' => $request->u_password,
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($showroom) {
            return redirect()->route('super_admin.surgical_showrooms')->with('success', 'Showroom created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function editShowroom($id)
    {
        $pageTitle = 'Edit Surgical Showroom';
        $showroom = DB::table('showrooms')->where('id', $id)->first();
        return view('admin.showrooms.edit', compact('pageTitle', 'showroom'));
    }

    public function updateShowroom(Request $request, $id)
    {
        $request->validate([
            'showroom_name' => 'required',
            'whatsapp_number' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'email' => 'required|email|unique:showrooms,email,'.$id,
            'u_password' => 'required',
            'confirm_password' => 'required|same:u_password',
            'status' => 'required',
        ], [
            'showroom_name.required' => 'Showroom name is required',
            'whatsapp_number.required' => 'Whatsapp number is required',
            'contact_name.required' => 'Contact name is required',
            'contact_number.required' => 'Contact number is required',
            'address.required' => 'Location is required',
            'country.required' => 'Country is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'u_password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Confirm password must be same as password',
            'status.required' => 'Status is required',
        ]);

        $showroomDetails = DB::table('showrooms')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $showroomDetails->user_id)->update([
            'name' => $request->contact_name,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $showroom = DB::table('showrooms')->where('id', $id)->update([
            'showroom_name' => $request->showroom_name,
            'whatsapp_number' => $request->whatsapp_number,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'simple_password' => $request->u_password,
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($showroom) {
            return redirect()->route('super_admin.surgical_showrooms')->with('success', 'Showroom updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function deleteShowroom($id)
    {
        $showroomDetails = DB::table('showrooms')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $showroomDetails->user_id)->delete();
        $showroom = DB::table('showrooms')->where('id', $id)->delete();
        if ($showroom) {
            return redirect()->route('super_admin.surgical_showrooms')->with('success', 'Showroom deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}