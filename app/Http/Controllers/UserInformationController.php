<?php

namespace App\Http\Controllers;

use App\Models\HelperModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserInformationController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('user.index');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("users");
        return view('user._list')->with('users',$list);
    }

    public function GetAllJson()
    {
        $user = HelperModel::GetAll("users");
        return response()->json($user);
    }

    public function GetSingle(Request $request)
    {
        $user = HelperModel::GetSingle("users","id",$request->id);
        $user_information = HelperModel::GetSingle("user_information","user_id",$request->id);
        return response()->json([
            'user' => $user,
            'user_information' => $user_information
        ]);
    }

    public function Save(Request $request)
    {
        //return response()->json($request);
        if ($request->isDelete == 'true')
        {
            //DELETE
            HelperModel::DeleteSingle("users","id",$request->user_id);
            HelperModel::DeleteSingle("user_information","user_id",$request->user_id);
        }
        else
        {
            if ($request->user_id > 0)
            {
                $request->merge(["id"=>$request->user_id]);
                $request->merge(["email"=>$request->username]);
                $request['password'] = Hash::make($request->password);
                Arr::except($request,['user_id','firstname','middlename','lastname','username']);
                //UPDATE
                HelperModel::UpdateModel("users","id",$request->id,$request);
            }
            else
            {
                $user_information_array = $request->all();

                $name = $request['firstname'].' '.$request['middlename'].' '.$request['lastname'];
                $request->merge(["name"=>$name]);
                $request['email'] = $request->username;
                $request['password'] = Hash::make($request->password);
                $final_object = Arr::except($request,['user_id','firstname','middlename','lastname','username']);
                $insert_user = HelperModel::Create("users",$final_object);

                if ($insert_user >= 0)
                {
                    $new_array = array_merge($user_information_array,["user_id" => $insert_user]);
                    $user_info = Arr::except($new_array,['_token','isDelete','username','password']);
                    DB::table('user_information')->insert($user_info);
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function show(UserInformation $userInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInformation $userInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInformation $userInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInformation $userInformation)
    {
        //
    }
}
