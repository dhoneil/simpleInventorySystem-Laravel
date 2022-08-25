<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\HelperModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\RegistrationToken;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registration_token()
    {
        return view('auth.registration_token');
    }
    public function index()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $token_registration = $request->registration_token;
        $registration_token = RegistrationToken::where('token', '=',$token_registration)->first();
        if ($registration_token === null)
        {
            return response()->json(['message'=>'Invalid Token'],500);
        }
        else
        {
            $user_information_array = $request->all();

            $name = $request['firstname'].' '.$request['middlename'].' '.$request['lastname'];

            $request->merge(["role_id" => 3]); // customer id in user_roles table
            $request->merge(["name"=>$name]);
            $request['email'] = $request->email;
            $request['password'] = Hash::make($request->password);

            $final_object = Arr::except($request,['user_id','firstname','middlename','lastname','username','registration_token']);

            $insert_user = HelperModel::Create("users",$final_object);

            if ($insert_user >= 0)
            {
                $new_array = array_merge($user_information_array,["user_id" => $insert_user]);
                $user_info = Arr::except($new_array,['_token','isDelete','username','password','email','registration_token']);

                //insert user info
                DB::table('user_information')->insert($user_info);

                //delete token
                HelperModel::DeleteSingle("registration_tokens","token",$token_registration);

                return true;
            }


        }
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password']));

        auth()->login($user);

        return redirect()->to('/games');
    }
}
