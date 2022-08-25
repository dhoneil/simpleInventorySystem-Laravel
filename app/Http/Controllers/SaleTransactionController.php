<?php

namespace App\Http\Controllers;

use App\Models\HelperModel;
use Illuminate\Http\Request;
use App\Models\SaleTransaction;

class SaleTransactionController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('sale_transaction.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("sale_transactions");
        return view('sale_transaction._list')->with('sale_transactions',$list);
    }

    public function GetSingle(Request $request)
    {
        $sale_transaction = HelperModel::GetSingle("sale_transactions","sale_transaction_id",$request->sale_transaction_id);
        return response()->json([
            'sale_transaction' => $sale_transaction
        ]);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("sale_transactions","sale_transaction_id",$request->sale_transaction_id);
        }
        else
        {
            if ($request->sale_transaction_id > 0)
            {
                HelperModel::UpdateModel("sale_transactions","sale_transaction_id",$request->sale_transaction_id,$request);
            }
            else
            {
                HelperModel::Create("sale_transactions",$request);
            }
        }
    }
}
