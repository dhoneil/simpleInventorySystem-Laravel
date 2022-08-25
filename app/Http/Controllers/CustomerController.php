<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HelperModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('customer.index');
    }

    public function getCustomers()
    {
        $list = DB::table('user_information as ui')
        ->join('users as u','u.id','=','ui.user_id')
        ->where('u.role_id','=',3)//customer
        ->select('u.id','ui.firstname','ui.middlename','ui.lastname')
        ->get();
        return $list;
    }

    public function GetAll()
    {
        $list = $this->getCustomers();
        return view('customer._list')->with('customers',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("customers");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $customer = HelperModel::GetSingle("customers","customer_id",$request->customer_id);
        return response()->json($customer);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("customers","customer_id",$request->customer_id);
        }
        else
        {
            if ($request->customer_id > 0)
            {
                HelperModel::UpdateModel("customers","customer_id",$request->customer_id,$request);
            }
            else
            {
                $fullname = $request['firstname'].' '.$request['middlename'].' '.$request['lastname'];

                //insert user
                $user_id = DB::table('users')->insertGetId([
                    'name' => $fullname,
                    'email' => str_replace(' ', '', $fullname).'@test.com',
                    'password' => Hash::make(1234),
                    'role_id' => 3 //customer
                ]);

                //insert user information
                DB::table('user_information')->insertGetId([
                    'user_id'=>$user_id,
                    'firstname'=>$request->firstname,
                    'middlename'=>$request->middlename,
                    'lastname'=>$request->lastname
                ]);

            }
        }
    }
}
