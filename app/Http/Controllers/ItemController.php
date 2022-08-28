<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\HelperModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

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
            $is_unique_item = DB::table('items')
                                ->where('item_name',$request->item_name)
                                ->where('item_description',$request->item_description)
                                ->first();

            if ($is_unique_item == null && $request->item_name != null) {
                if ($request->item_id > 0)
                    HelperModel::UpdateModel("items","item_id",$request->item_id,$request);
                else
                    HelperModel::Create("items",$request);
            }else{
                return response()->json([
                    'code'=>404,
                    'message'=>($request->item_name == null ? "Item name can not be null" : 'Item with the same name and description already exists'),
                ],404);
            }
        }
    }

    public function GetInOutItems(Request $request)
    {
        $item_id = $request->item_id;
        $transaction_type = $request->transaction_type;
        $list = DB::table('item_in_outs')
                        ->join('items','item_in_outs.item_id','=','items.item_id')
                        ->where('item_in_outs.item_id','=',$item_id)
                        ->where('item_in_outs.item_transaction_type','=',$transaction_type)
                        ->select('items.*', 'item_in_outs.created_at',
                                 'item_in_outs.qty as qty')
                        ->get();
        return view('item._itemInlist')->with('items',$list);
    }
}
