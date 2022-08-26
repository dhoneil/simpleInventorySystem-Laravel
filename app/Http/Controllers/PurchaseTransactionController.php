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
        return view('purchase_transaction.index');
    }

    public function GetAll()
    {
        // $list = HelperModel::GetAll("purchase_transactions");
        $list = DB::table('purchase_transactions')
                        ->join('items','items.item_id','=','purchase_transactions.item_id')
                        ->select('purchase_transactions.*', 'items.item_name', 'items.item_description','items.price')
                        ->get();
        return view('purchase_transaction._list')->with('purchase_transactions',$list);
    }

    public function GetSingle(Request $request)
    {
        $purchase_transaction = HelperModel::GetSingle("purchase_transactions","purchase_transaction_id",$request->purchase_transaction_id);
        return response()->json([
            'purchase_transaction' => $purchase_transaction
        ]);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("purchase_transactions","purchase_transaction_id",$request->purchase_transaction_id);
        }
        else
        {
            if ($request->purchase_transaction_id > 0)
            {
                HelperModel::UpdateModel("purchase_transactions","purchase_transaction_id",$request->purchase_transaction_id,$request);
            }
            else
            {
                $res = HelperModel::Create("purchase_transactions",$request);
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
