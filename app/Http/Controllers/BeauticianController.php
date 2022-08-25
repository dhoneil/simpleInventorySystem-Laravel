<?php

namespace App\Http\Controllers;

use App\Models\Beautician;
use App\Models\HelperModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\BeauticianService;
use Illuminate\Support\Facades\DB;

class BeauticianController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('beautician.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("beauticians");
        return view('beautician._list')->with('beauticians',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("beauticians");
        return response()->json($list);
    }

    public function GetBeauticianServices(Request $request)
    {
        $services = DB::table('beautician_services')
                    ->where('beautician_id', '=' , $request->beautician_id)
                    ->select('service_id')
                    ->get();
        return response()->json($services);
    }

    public function GetSingle(Request $request)
    {
        $beautician = HelperModel::GetSingle("beauticians","beautician_id",$request->beautician_id);
        return response()->json($beautician);
    }

    public function Save(Request $request)
    {
        $request_handler = $request->all();
        $request_handler_object = (object) $request_handler;

        $final_beautician_object = Arr::except($request,['services']);

        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("beauticians","beautician_id",$request->beautician_id);
        }
        else
        {
            if ($request->beautician_id > 0)
            {
                HelperModel::UpdateModel("beauticians","beautician_id",$request->beautician_id,$final_beautician_object);
            }
            else
            {
                $create_beautician = HelperModel::Create("beauticians",$final_beautician_object);

                foreach ($request_handler_object->services as $service)
                {
                    $beauticianService = new BeauticianService;
                    $beauticianService->beautician_id = $create_beautician;
                    $beauticianService->service_id = $service;
                    HelperModel::Create("beautician_services",$beauticianService);
                }
            }
        }

        return $request;
    }
}
