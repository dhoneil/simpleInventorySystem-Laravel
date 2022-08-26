<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\HelperModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('item.index');
    }

    public function GetAll()
    {
        $list = DB::table('items')
                        ->join('item_codes','items.item_code_id','=','item_codes.item_code_id')
                        ->join('item_genres','items.item_genre_id','=','item_genres.item_genre_id')
                        ->select('items.*', 'item_codes.item_code_name', 'item_genres.item_genre_name')
                        ->get();
        return view('item._list')->with('items',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("items");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $item = HelperModel::GetSingle("items","item_id",$request->item_id);
        return response()->json([
            'item' => $item
        ]);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("items","item_id",$request->item_id);
        }
        else
        {
            if ($request->item_id > 0)
            {
                HelperModel::UpdateModel("items","item_id",$request->item_id,$request);
            }
            else
            {
                HelperModel::Create("items",$request);
            }
        }
    }
}
