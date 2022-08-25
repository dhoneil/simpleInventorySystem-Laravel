<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('user_role.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("user_roles");
        return view('user_role._list')->with('user_roles',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("user_roles");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $service = HelperModel::GetSingle("user_roles","user_role_id",$request->user_role_id);
        return response()->json($service);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("user_roles","user_role_id",$request->user_role_id);
        }
        else
        {
            if ($request->user_role_id > 0)
            {
                HelperModel::UpdateModel("user_roles","user_role_id",$request->user_role_id,$request);
            }
            else
            {
                HelperModel::Create("user_roles",$request);
            }
        }
    }
}
