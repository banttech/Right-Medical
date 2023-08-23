<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ServiceEngineerController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Service Requests';
        $service_engineer = DB::table('service_engineers')
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($request->has('search')) {
            $serviceRequests = DB::table('service_requests')
                ->where('service_engineer', $service_engineer->id)
                ->where(function ($query) use ($request) {
                    $query->where('machine_name', 'like', '%' . $request->search . '%')
                          ->orWhere('model_no', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(50);
        } else {
            $serviceRequests = DB::table('service_requests')
                ->where('service_engineer', $service_engineer->id)
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        return view('frontend.service_engineer.service_request.index', compact('pageTitle', 'serviceRequests'));
    }

    public function profileInformation()
    {
        $pageTitle = 'Profile Information';
        $service_engineer = DB::table('service_engineers')->where('user_id', Auth::user()->id)->first();
        return view('frontend.profiles.service_engineer_profile', compact('pageTitle', 'service_engineer'));
    }

    public function trackingNumberDetails($requestId)
    {
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

        return view('frontend.service_engineer.service_request.tracking_number_details', compact('pageTitle', 'serviceRequest', 'agentGeneratedReport'));
    }

    public function createServiceReport($requestId){
        $pageTitle = 'Create Service Report';
        return view('frontend.service_engineer.service_request.create_service_report', compact('pageTitle', 'requestId'));
    }

    public function saveServiceReport(Request $request, $requestId){
        $request->validate([
            'problem_description' => 'required',
            'spare_parts_needed' => 'required',
            'damage_machine_photos' => 'required',
            'engineer_voice_note' => 'required',
            'repaire_status' => 'required',
        ],[
            'problem_description.required' => 'Problem description is required',
            'spare_parts_needed.required' => 'Spare parts needed is required',
            'damage_machine_photos.required' => 'Damage machine photos is required',
            'engineer_voice_note.required' => 'Voice note is required',
            'repaire_status.required' => 'Repaire status is required',
        ]);

        $damage_machine_photos = $request->file('damage_machine_photos');
        $pictures = [];
        if($damage_machine_photos){
            foreach ($damage_machine_photos as $key => $value) {
                $picture_name = date('YmdHis') . $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('admin_assets/img/problem_pictures'), $picture_name);
                $pictures[] = $picture_name;
            }
        }

        $data = [
            'request_id' => $requestId,
            'engineer_id' => Auth::user()->id,
            'problem_description' => $request->problem_description,
            'spare_parts_needed' => $request->spare_parts_needed,
            'damage_machine_photos' => implode(',', $pictures),
            'repaire_status' => $request->repaire_status,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if($request->file('engineer_voice_note')){
            $audio = $request->file('engineer_voice_note');
            $mime = $audio->getClientMimeType();
            $extension = $mime == 'audio/wav' ? 'wav' : 'mp3';
            $filename = time() . '.' . $extension;
            $audio->move(public_path('voices'), $filename);

            $data['engineer_voice_note'] = $filename;
        }

        $insert = DB::table('service_engineer_reports')->insert($data);

        if($insert){
            return redirect()->route('service_engineer.service_requests')->with('success', 'Service report created successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function editServiceReport($requestId){
        $pageTitle = 'Edit Service Report';
        $serviceReport = DB::table('service_engineer_reports')
            ->where('request_id', $requestId)
            ->first();
        return view('frontend.service_engineer.service_request.edit_service_report', compact('pageTitle', 'requestId', 'serviceReport'));
    }

    public function updateServiceReport(Request $request, $requestId){
        $request->validate([
            'problem_description' => 'required',
            'spare_parts_needed' => 'required',
            'repaire_status' => 'required',
        ],[
            'problem_description.required' => 'Problem description is required',
            'spare_parts_needed.required' => 'Spare parts needed is required',
            'repaire_status.required' => 'Repaire status is required',
        ]);

        $serviceEngineerReport = DB::table('service_engineer_reports')
            ->where('request_id', $requestId)
            ->first();

        $damagePictures = [];
        if($request->hasFile('damage_machine_photos')){
            $damage_machine_photos = $request->file('damage_machine_photos');
            if($damage_machine_photos){
                foreach ($damage_machine_photos as $key => $value) {
                    $picture_name = date('YmdHis') . $key . '.' . $value->getClientOriginalExtension();
                    $value->move(public_path('admin_assets/img/problem_pictures'), $picture_name);
                    $damagePictures[] = $picture_name;
                }
            }
        }

        $repairedPictures = [];
        if($request->hasFile('repaired_machine_photos')){
            $repaired_machine_photos = $request->file('repaired_machine_photos');
            if($repaired_machine_photos){
                foreach ($repaired_machine_photos as $key => $value) {
                    $picture_name = date('YmdHis') . $key . '.' . $value->getClientOriginalExtension();
                    $value->move(public_path('admin_assets/img/repaired_machine_pictures'), $picture_name);
                    $repairedPictures[] = $picture_name;
                }
            }
        }

        $data = [
            'problem_description' => $request->problem_description,
            'spare_parts_needed' => $request->spare_parts_needed,
            'damage_machine_photos' => count($damagePictures) > 0 ? implode(',', $damagePictures) : $serviceEngineerReport->damage_machine_photos,
            'repaired_machine_photos' => count($repairedPictures) > 0 ? implode(',', $repairedPictures) : $serviceEngineerReport->repaired_machine_photos,
            'repaire_status' => $request->repaire_status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if($request->file('engineer_voice_note')){
            $audio = $request->file('engineer_voice_note');
            $mime = $audio->getClientMimeType();
            $extension = $mime == 'audio/wav' ? 'wav' : 'mp3';
            $filename = time() . '.' . $extension;
            $audio->move(public_path('voices'), $filename);

            $data['engineer_voice_note'] = $filename;
        }

        $update = DB::table('service_engineer_reports')
            ->where('request_id', $requestId)
            ->update($data);

        if($update){
            // if repaire_status is repaired then update work_status to completed in service_requests table also change status to Repaired
            if($request->repaire_status == 'repaired'){
                $update = DB::table('service_requests')
                    ->where('id', $requestId)
                    ->update([
                        'work_status' => 'completed',
                        'status' => 'repaired',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
            if($update){
                return redirect()->route('service_engineer.service_requests')->with('success', 'Service report updated successfully');
            }else{
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function startWork($requestId){
        $update = DB::table('service_requests')
            ->where('id', $requestId)
            ->update([
                'work_status' => 'started',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if($update){
            return redirect()->route('service_engineer.service_requests')->with('success', 'Work started successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}