<?php

namespace App\Http\Controllers;

use App\Models\ItemGenre;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class ItemGenreController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('item_genre.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("item_genres");
        return view('item_genre._list')->with('item_genres',$list);
    }

    public function GetSingle(Request $request)
    {
        $item_genre = HelperModel::GetSingle("item_genres","item_genre_id",$request->item_genre_id);
        return response()->json([
            'item_genre' => $item_genre
        ]);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("item_genres","item_genre_id",$request->item_genre_id);
        }
        else
        {
            if ($request->item_genre_id > 0)
            {
                HelperModel::UpdateModel("item_genres","item_genre_id",$request->item_genre_id,$request);
            }
            else
            {
                HelperModel::Create("item_genres",$request);
            }
        }
    }
}
