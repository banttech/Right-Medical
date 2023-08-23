<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Service Requests';
        if ($request->has('search')) {
            $serviceRequests = DB::table('service_requests')
                ->where('machine_name', 'like', '%' . $request->search . '%')
                ->orWhere('model_no', 'like', '%' . $request->search . '%')
                ->orderBy('id', 'desc')
                ->paginate(50);
        } else {
            $serviceRequests = DB::table('service_requests')
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        return view('admin.service_request.index', compact('pageTitle', 'serviceRequests'));
    }   

    public function assignAgent($requestId){
        $pageTitle = 'Assign Agent';
        $agents = DB::table('sales_agents')
            ->select('id', 'user_id', 'name', 'status')
            ->get();

        return view('admin.service_request.assign_agent', compact('pageTitle', 'agents', 'requestId'));
    }

    public function allocateToSalesAgent(Request $request, $requestId){
        $request->validate([
            'agent' => 'required',
        ],[
            'agent.required' => 'Agent is required',
        ]);

        $data = [
            'sales_agent' => $request->agent,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('service_requests')
            ->where('id', $requestId)
            ->update($data);

        return redirect()->route('super_admin.service_requests')->with('success', 'Agent assigned successfully');
    }

    public function assignEngineer($requestId){
        $pageTitle = 'Assign Engineer';
        $engineers = DB::table('service_engineers')
            ->select('id', 'user_id', 'name', 'status')
            ->get();

        return view('admin.service_request.assign_engineer', compact('pageTitle', 'engineers', 'requestId'));
    }

    public function allocateToServiceEngineer(Request $request, $requestId){
        $request->validate([
            'engineer' => 'required',
        ],[
            'engineer.required' => 'Engineer is required',
        ]);

        $data = [
            'service_engineer' => $request->engineer,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('service_requests')
            ->where('id', $requestId)
            ->update($data);

        return redirect()->route('super_admin.service_requests')->with('success', 'Engineer assigned successfully');
    }

    public function saveTrackingNumber(Request $request, $requestId)
    {
        $tracking_number = rand(1000000000, 9999999999);
        $data = [
            'tracking_no' => $tracking_number,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('service_requests')
            ->where('id', $requestId)
            ->update($data);

        return redirect()->route('super_admin.service_requests')->with('success', 'Tracking number generated successfully');
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

        return view('admin.service_request.tracking_number_details', compact('pageTitle', 'serviceRequest', 'agentGeneratedReport'));
    }

    public function serviceEngineerReport($requestId)
    {
        $pageTitle = 'Service Engineer Report';
        $serviceEngineerReport = DB::table('service_engineer_reports')
            ->where('request_id', $requestId)
            ->first();
        $serviceRequest = DB::table('service_requests')
            ->where('id', $requestId)
            ->first();

        return view('admin.service_request.service_engineer_report', compact('pageTitle', 'requestId', 'serviceEngineerReport', 'serviceRequest'));
    }

    public function updateServiceRequest(Request $request, $requestId)
    {
        $request->validate([
            'spare_parts_cost' => 'required',
            'showroom_service_charges' => 'required',
        ],[
            'spare_parts_cost.required' => 'Spare parts cost is required',
            'showroom_service_charges.required' => 'Showroom service charges is required',
        ]);

        $data = [
            'spare_parts_cost' => $request->spare_parts_cost,
            'showroom_service_charges' => $request->showroom_service_charges,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('service_requests')
            ->where('id', $requestId)
            ->update($data);

        return redirect()->route('super_admin.service_requests')->with('success', 'Service request updated successfully');
    }

    public function changeDeviceReceivingStatus(Request $request)
    {
        $serviceRequest = DB::table('service_requests')
            ->where('id', $request->requestId)
            ->first();

        if($serviceRequest->device_receiving_status == 'received'){
            $data = [
                'device_receiving_status' => 'unreceived',
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }else{
            $data = [
                'device_receiving_status' => 'received',
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('service_requests')
            ->where('id', $request->requestId)
            ->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Device receiving status changed successfully',
        ]);
    }
}