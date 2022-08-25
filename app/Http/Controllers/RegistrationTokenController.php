<?php

namespace App\Http\Controllers;

use App\Models\HelperModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RegistrationToken;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;

class RegistrationTokenController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('registration_token.index');
    }

    public function generate_token()
    {
      return response()->json(Str::random(8));
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("registration_tokens");
        return view('registration_token._list')->with('registration_tokens',$list);
    }

    public function GetAllJson()
    {
        $list = HelperModel::GetAll("registration_tokens");
        return response()->json($list);
    }

    public function GetSingle(Request $request)
    {
        $service = HelperModel::GetSingle("registration_tokens","registration_token_id",$request->registration_token_id);
        return response()->json($service);
    }

    public function Save(Request $request)
    {
        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("registration_tokens","registration_token_id",$request->registration_token_id);
        }
        else
        {
            if ($request->registration_token_id > 0)
            {
                HelperModel::UpdateModel("registration_tokens","registration_token_id",$request->registration_token_id,$request);
            }
            else
            {
				$token = RegistrationToken::where('token', '=',$request->token)->first();
				if ($token === null) {
					HelperModel::Create("registration_tokens",$request);
					return 1;
				}
            }
        }
    }


}
