<?php

namespace App\Http\Controllers;

use App\Models\HelperModel;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function GetSingleJson(Request $request)
    {
        $entity = HelperModel::GetSingle($request->tablename,$request->column,$request->columnvalue);
        return response()->json($entity);
    }
}
