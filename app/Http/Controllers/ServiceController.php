<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('service.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("services");
        return view('service._list')->with('services',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("services");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $service = HelperModel::GetSingle("services","service_id",$request->service_id);
        return response()->json($service);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("services","service_id",$request->service_id);
        }
        else
        {
            if ($request->service_id > 0)
            {
                HelperModel::UpdateModel("services","service_id",$request->service_id,$request);
            }
            else
            {
                HelperModel::Create("services",$request);
            }
        }
    }
}
