<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Service Requests';
        if ($request->has('search')) {
            $serviceRequests = DB::table('service_requests')
                ->where('posted_by', Auth::user()->id)
                ->where(function ($query) use ($request) {
                    $query->where('machine_name', 'like', '%' . $request->search . '%')
                          ->orWhere('model_no', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(50);
        } else {
            $serviceRequests = DB::table('service_requests')
                ->where('posted_by', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        return view('frontend.showroom_owner.service_request.index', compact('pageTitle', 'serviceRequests'));
    }

    public function addServiceRequest(){
        $pageTitle = 'Add Service Request';
        return view('frontend.showroom_owner.service_request.create', compact('pageTitle'));
    }

    public function createServiceRequest(Request $request){
        $request->validate([
            'machine_name' => 'required',
            'model_no' => 'required',
            'problem_description' => 'required',
            'showroom_voice_note' => 'required',
            'machine_collect_method' => 'required',
            'showroom_problem_image' => 'required|image|mimes:jpeg,png,jpg',
        ],[
            'machine_name.required' => 'Machine Name is required',
            'model_no.required' => 'Model No is required',
            'problem_description.required' => 'Problem Description is required',
            'showroom_voice_note.required' => 'Voice Note is required',
            'machine_collect_method.required' => 'Machine Collect Method is required',
            'showroom_problem_image.required' => 'Showroom Problem Image is required',
            'showroom_problem_image.image' => 'Showroom Problem Image must be type of jpeg, png, jpg',
        ]);

        $data = [
            'machine_name' => $request->machine_name,
            'model_no' => $request->model_no,
            'problem_description' => $request->problem_description,
            'problem_occured_date' => date('Y-m-d H:i:s'),
            'posted_by' => Auth::user()->id,
            'machine_collect_method' => $request->machine_collect_method,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($request->hasFile('showroom_problem_image')) {
            $image = $request->file('showroom_problem_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin_assets/img/problem_pictures'), $imageName);
            $data['showroom_problem_image'] = $imageName;
        }


        $audio = $request->file('showroom_voice_note');
        $mime = $audio->getClientMimeType();
        $extension = $mime == 'audio/wav' ? 'wav' : 'mp3';
        $filename = time() . '.' . $extension;
        $audio->move(public_path('voices'), $filename);

        $data['showroom_voice_note'] = $filename;
        $serviceRequest = DB::table('service_requests')->insert($data);

        if($serviceRequest){
            return redirect()->route('showroom_owner.service_requests')->with('success', 'Service Request Created Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function editServiceRequest($id){
        $pageTitle = 'Edit Service Request';
        $serviceRequest = DB::table('service_requests')->where('id', $id)->first();
        return view('frontend.showroom_owner.service_request.edit', compact('pageTitle', 'serviceRequest'));
    }

    public function updateServiceRequest(Request $request, $id){
        $request->validate([
            'machine_name' => 'required',
            'model_no' => 'required',
            'problem_description' => 'required',
            'machine_collect_method' => 'required',
            'showroom_problem_image' => 'image|mimes:jpeg,png,jpg',
        ],[
            'machine_name.required' => 'Machine Name is required',
            'model_no.required' => 'Model No is required',
            'problem_description.required' => 'Problem Description is required',
            'machine_collect_method.required' => 'Machine Collect Method is required',
            'showroom_problem_image.image' => 'Showroom Problem Image must be type of jpeg, png, jpg',
        ]);

        $data = [
            'machine_name' => $request->machine_name,
            'model_no' => $request->model_no,
            'problem_description' => $request->problem_description,
            'machine_collect_method' => $request->machine_collect_method,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($request->hasFile('showroom_problem_image')) {
            $image = $request->file('showroom_problem_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin_assets/img/problem_pictures'), $imageName);
            $data['showroom_problem_image'] = $imageName;
        }

        if($request->file('showroom_voice_note')){
            $audio = $request->file('showroom_voice_note');
            $mime = $audio->getClientMimeType();
            $extension = $mime == 'audio/wav' ? 'wav' : 'mp3';
            $filename = time() . '.' . $extension;
            $audio->move(public_path('voices'), $filename);

            $data['showroom_voice_note'] = $filename;
        }

        $serviceRequest = DB::table('service_requests')->where('id', $id)->update($data);

        if($serviceRequest){
            return redirect()->route('showroom_owner.service_requests')->with('success', 'Service Request Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function deleteServiceRequest($id){
        $serviceRequest = DB::table('service_requests')->where('id', $id)->delete();
        if($serviceRequest){
            return redirect()->route('showroom_owner.service_requests')->with('success', 'Service Request Deleted Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function trackingNumberDetails($requestId){
        $pageTitle = 'Tracking Number Details';
        $serviceRequest = DB::table('service_requests')
            ->where('id', $requestId)
            ->first();
        $agentGeneratedReport = [];

        if($serviceRequest->machine_collect_method == 'pickup'){
            $agentGeneratedReport = DB::table('agent_generated_tracking_report')
                ->where('request_id', $requestId)
                ->first();
        }

        return view('frontend.showroom_owner.service_request.tracking_number_details', compact('pageTitle', 'serviceRequest', 'agentGeneratedReport'));
    }

    public function approveServiceRequest($requestId){
        $serviceRequest = DB::table('service_requests')
            ->where('id', $requestId)
            ->update([
                'showroom_approval' => 'approved',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if($serviceRequest){
            return redirect()->route('showroom_owner.service_requests')->with('success', 'Service Request Approved Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function disapproveServiceRequest($requestId){
        $serviceRequest = DB::table('service_requests')
            ->where('id', $requestId)
            ->update([
                'showroom_approval' => 'disapproved',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if($serviceRequest){
            return redirect()->route('showroom_owner.service_requests')->with('success', 'Service Request Disapproved Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}