<?php

namespace App\Http\Controllers;

use App\Models\ItemInOut;
use App\Models\HelperModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseTransaction;

class PurchaseTransactionController extends Controller
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
        // $list = HelperModel::GetAll("sale_transactions");
        $list = DB::table('purchase_transactions')
                        ->join('items','items.item_id','=','purchase_transactions.item_id')
                        ->select('purchase_transactions.*', 'items.item_name', 'items.item_description')
                        ->get();
        return view('sale_transaction._list')->with('purchase_transactions',$list);
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
                $res = HelperModel::Create("sale_transactions",$request);
                if ($res > 0) {
                    //save as out
                    $in = new ItemInOut();
                    $in->item_id = $request->item_id;
                    $in->qty = $request->qty;
                    $in->item_transaction_type = 1;
                    $in->save();
                }
            }
        }
    }
}
