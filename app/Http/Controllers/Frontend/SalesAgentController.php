<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SalesAgentController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Service Requests';
        $sales_agent = DB::table('sales_agents')
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($request->has('search')) {
            $serviceRequests = DB::table('service_requests')
                ->where('sales_agent', $sales_agent->id)
                ->where(function ($query) use ($request) {
                    $query->where('machine_name', 'like', '%' . $request->search . '%')
                          ->orWhere('model_no', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(50);
        } else {
            $serviceRequests = DB::table('service_requests')
                ->where('sales_agent', $sales_agent->id)
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        return view('frontend.sales_agent.service_request.index', compact('pageTitle', 'serviceRequests'));
    }

    public function profileInformation()
    {
        $pageTitle = 'Profile Information';
        $sales_agent = DB::table('sales_agents')->where('user_id', Auth::user()->id)->first();
        return view('frontend.profiles.sales_agent_profile', compact('pageTitle', 'sales_agent'));
    }

    public function generateTrackingNumber($requestId)
    {
        $pageTitle = 'Generate Tracking Number';
        return view('frontend.sales_agent.service_request.generate_tracking_number', compact('pageTitle', 'requestId'));
    }

    public function saveTrackingNumber(Request $request, $requestId)
    {
        $request->validate([
            'problem_description' => 'required',
            'agent_voice_note' => 'required',
            'problem_pictures' => 'required',
        ],[
            'problem_description.required' => 'Problem description is required',
            'agent_voice_note.required' => 'Agent Voice note is required',
            'problem_pictures.required' => 'Problem pictures are required',
        ]);

        $tracking_number = rand(1000000000, 9999999999);
        $data = [
            'tracking_no' => $tracking_number,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('service_requests')
            ->where('id', $requestId)
            ->update($data);


        $problem_pictures = $request->file('problem_pictures');
        $pictures = [];
        foreach ($problem_pictures as $key => $value) {
            $picture_name = $tracking_number . '_' . $key . '.' . $value->getClientOriginalExtension();
            $value->move(public_path('admin_assets/img/problem_pictures'), $picture_name);
            $pictures[] = $picture_name;
        }

        $data = [
            'request_id' => $requestId,
            'agent_id' => Auth::user()->id,
            'tracking_no' => $tracking_number,
            'problem_description' => $request->problem_description,
            'voice_note' => $request->voice_note,
            'problem_pictures' => implode(',', $pictures),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if($request->file('agent_voice_note')){
            $audio = $request->file('agent_voice_note');
            $mime = $audio->getClientMimeType();
            $extension = $mime == 'audio/wav' ? 'wav' : 'mp3';
            $filename = time() . '.' . $extension;
            $audio->move(public_path('voices'), $filename);

            $data['agent_voice_note'] = $filename;
        }

        DB::table('agent_generated_tracking_report')->insert($data);

        return redirect()->route('sales_agent.service_requests')->with('success', 'Tracking number generated successfully');
    }

    public function trackingNumberDetails($requestId)
    {
        $pageTitle = 'Tracking Number Details';
        $trackingNumberDetails = DB::table('agent_generated_tracking_report')
            ->where('request_id', $requestId)
            ->first();
        return view('frontend.sales_agent.service_request.tracking_number_details', compact('pageTitle', 'trackingNumberDetails'));
    }
}