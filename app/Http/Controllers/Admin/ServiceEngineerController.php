<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceEngineerController extends Controller
{
    public function index(Request $request){
        $pageTitle = 'Service Engineers';
        if ($request->has('search')) {
            $engineers = DB::table('service_engineers')
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('contact_number', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%')
                ->paginate(50);
        } else {
            $engineers = DB::table('service_engineers')->paginate(50);
        }
        return view('admin.service_engineers.index', compact('pageTitle', 'engineers'));
    }

    public function addServiceEngineer(){
        $pageTitle = 'Add Service Engineer';
        return view('admin.service_engineers.create', compact('pageTitle'));
    }

    public function createServiceEngineer(Request $request){
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email|unique:users',
            'u_password' => 'required',
            'confirm_password' => 'required|same:u_password',
        ], [
            'name.required' => 'Name is required',
            'status.required' => 'Status is required',
            'address.required' => 'Address is required',
            'country.required' => 'Country is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'contact_number.required' => 'Contact number is required',
            'u_password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Password and confirm password must be same',
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'role' => 'service_engineer',
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $engineer = DB::table('service_engineers')->insert([
            'user_id' => $userId,
            'email' => $request->email,
            'name' => $request->name,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->u_password),
            'simple_password' => $request->u_password,
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($engineer) {
            return redirect()->route('super_admin.service_engineers')->with('success', 'Service Engineer added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function editServiceEngineer($id){
        $pageTitle = 'Edit Service Engineer';
        $engineer = DB::table('service_engineers')->where('id', $id)->first();
        return view('admin.service_engineers.edit', compact('pageTitle', 'engineer'));
    }

    public function updateServiceEngineer(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email|unique:service_engineers,email,'.$id,
            'u_password' => 'required',
            'confirm_password' => 'required|same:u_password',
        ], [
            'name.required' => 'Name is required',
            'status.required' => 'Status is required',
            'address.required' => 'Address is required',
            'country.required' => 'Country is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'contact_number.required' => 'Contact number is required',
            'u_password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Password and confirm password must be same',
        ]);

        $serviceEngineerDetails = DB::table('service_engineers')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $serviceEngineerDetails->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'updated_at' => now(),
        ]);

        $engineer = DB::table('service_engineers')->where('id', $id)->update([
            'email' => $request->email,
            'name' => $request->name,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->u_password),
            'simple_password' => $request->u_password,
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($engineer) {
            return redirect()->route('super_admin.service_engineers')->with('success', 'Service Engineer updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function deleteServiceEngineer($id){
        $serviceEngineerDetails = DB::table('service_engineers')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $serviceEngineerDetails->user_id)->delete();
        $engineer = DB::table('service_engineers')->where('id', $id)->delete();

        if ($engineer) {
            return redirect()->route('super_admin.service_engineers')->with('success', 'Service Engineer deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}