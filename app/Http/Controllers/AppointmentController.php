<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Models\Appointment;
use App\Models\HelperModel;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function index()
    {
        return view('appointment.index');
    }

    public function external()
    {
        return view('appointment.external');
    }

    public function GetAll()
    {
        $list = HelperModel::GetAll("appointments");
        $customers = HelperModel::GetAll("customers");
        return view('appointment._list')->with([
            'appointments' => $list,
            'customers' => $customers
        ]);
    }

    public function GetSingle(Request $request)
    {
        $customer = HelperModel::GetSingle("appointments","appointment_id",$request->appointment_id);

        //CONVERT PHP DATETIME TO JS
        $date = new \DateTime($customer->schedule);
        $finalsched = $date->format(DateTime::W3C);
        $customer->schedule = $finalsched;

        return response()->json($customer);
    }

    public function Save(Request $request)
    {
        //CONVERT JS DATETIME TO PHP DATETIME
        $datestr = $request->schedule;
        $date = DateTime::createFromFormat('m/d/Y h:i A', $datestr);
        $finalsched = $date->format('Y-m-d H:i:s');
        $request['schedule'] = $finalsched;

        if ($request->isDelete == 'true')
        {
            HelperModel::DeleteSingle("appointments","appointment_id",$request->appointment_id);
        }
        else
        {
            if ($request->appointment_id > 0)
            {
                HelperModel::UpdateModel("appointments","appointment_id",$request->appointment_id,$request);
            }
            else
            {
                HelperModel::Create("appointments",$request);
            }
        }
    }

}
