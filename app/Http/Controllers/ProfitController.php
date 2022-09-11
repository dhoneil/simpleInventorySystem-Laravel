<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('profit.index');
    }

    public function GetAllProfit(Request $request)
    {
        $from = $request->datefrom;
        $to = $request->dateto;
        $revenues = DB::table('sale_transactions')
                        ->join('items','items.item_id','=','sale_transactions.item_id')
                        ->whereBetween('sale_transactions.transaction_date', [$from, $to])
                        ->select('sale_transactions.*', 'items.item_name', 'items.item_description','items.price')
                        ->get();
        return view('profit._saleslist')->with('sale_transactions',$revenues);
    }

    public function GetAllExpenses(Request $request)
    {
        $from = $request->datefrom;
        $to = $request->dateto;

        $expenses = DB::table('purchase_transactions')
                        ->join('items','items.item_id','=','purchase_transactions.item_id')
                        ->whereBetween('purchase_transactions.transaction_date', [$from, $to])
                        ->select('purchase_transactions.*', 'items.item_name', 'items.item_description','items.price')
                        ->get();
        return view('profit._expenseslist')->with('purchase_transactions',$expenses);
    }
}
