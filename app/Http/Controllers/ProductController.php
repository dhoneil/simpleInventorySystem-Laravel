<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('product.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("products");
        return view('product._list')->with('products',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("products");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $service = HelperModel::GetSingle("products","product_id",$request->product_id);
        return response()->json($service);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("products","product_id",$request->product_id);
        }
        else
        {
            if ($request->product_id > 0)
            {
                HelperModel::UpdateModel("products","product_id",$request->product_id,$request);
            }
            else
            {
                HelperModel::Create("products",$request);
            }
        }
    }
}
