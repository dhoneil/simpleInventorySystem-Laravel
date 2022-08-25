<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware(['auth']);
	}

    public function appointment()
    {
        return view('user.appointment');
    }

    public function getBeauticians()
    {
        $beauticians_with_scheduled_appointments = DB::table('beauticians')
        ->join('appointments','beauticians.beautician_id','=','appointments.beautician_id')
        ->select('beauticians.*','appointments.schedule','appointments.appointment_status', 'appointments.appointment_id')
        ->get();

        return view('user._beautcianSchedule')->with('beauticians_with_scheduled_appointments', $beauticians_with_scheduled_appointments);
    }
}
