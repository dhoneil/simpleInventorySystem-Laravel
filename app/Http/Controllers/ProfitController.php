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

    public function GetItems(Request $request)
    {
        $from = $request->datefrom;
        $to = $request->dateto;
        $items_list = DB::table('items')
                        ->join('item_codes','items.item_code_id','=','item_codes.item_code_id')
                        ->join('item_genres','items.item_genre_id','=','item_genres.item_genre_id')
                        // ->whereBetween('sale_transactions.transaction_date', [$from, $to])
                        ->select('items.*', 'item_codes.item_code_name', 'item_genres.item_genre_name')
                        ->get();
        return view('profit._items')->with('items',$items_list);
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
