<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SalesAgentController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Sales Agents';
        if ($request->has('search')) {
            $agents = DB::table('sales_agents')
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('contact_number', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%')
                ->paginate(50);
        } else {
            $agents = DB::table('sales_agents')->paginate(50);
        }

        return view('admin.sales_agents.index', compact('pageTitle', 'agents'));
    }

    public function addSalesAgent()
    {
        $pageTitle = 'Add Sales Agent';
        return view('admin.sales_agents.create', compact('pageTitle'));
    }

    public function createSalesAgent(Request $request)
    {
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
            'role' => 'sales_agent',
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sales_agents')->insert([
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

        return redirect()->route('super_admin.sales_agents')->with('success', 'Sales agent created successfully');
    }

    public function editSalesAgent($id)
    {
        $pageTitle = 'Edit Sales Agent';
        $agent = DB::table('sales_agents')->where('id', $id)->first();
        return view('admin.sales_agents.edit', compact('pageTitle', 'agent'));
    }

    public function updateSalesAgent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email|unique:sales_agents,email,'.$id,
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

        $agentDetails = DB::table('sales_agents')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $agentDetails->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->u_password),
            'status' => $request->status == 1 ? 'active' : 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('sales_agents')->where('id', $id)->update([
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

        return redirect()->route('super_admin.sales_agents')->with('success', 'Sales agent updated successfully');
    }

    public function deleteSalesAgent($id)
    {
        $agentDetails = DB::table('sales_agents')->where('id', $id)->first();
        DB::table('users')->where('id', $agentDetails->user_id)->delete();
        DB::table('sales_agents')->where('id', $id)->delete();
        return redirect()->route('super_admin.sales_agents')->with('success', 'Sales agent deleted successfully');
    }
}