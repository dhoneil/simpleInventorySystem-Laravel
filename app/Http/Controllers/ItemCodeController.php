<?php

namespace App\Http\Controllers;

use App\Models\ItemCode;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class ItemCodeController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('item_code.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("item_codes");
        return view('item_code._list')->with('item_codes',$list);
    }

    public function GetSingle(Request $request)
    {
        $item_code = HelperModel::GetSingle("item_codes","item_code_id",$request->item_code_id);
        return response()->json([
            'item_code' => $item_code
        ]);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("item_codes","item_code_id",$request->item_code_id);
        }
        else
        {
            if ($request->item_code_id > 0)
            {
                HelperModel::UpdateModel("item_codes","item_code_id",$request->item_code_id,$request);
            }
            else
            {
                HelperModel::Create("item_codes",$request);
            }
        }
    }
}
