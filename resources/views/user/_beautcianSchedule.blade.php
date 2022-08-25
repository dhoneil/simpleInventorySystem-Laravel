@php
    use Illuminate\Support\Facades\DB;
    use App\Models\HelperModel;
    use Illuminate\Support\Carbon;
@endphp

<div class="row">
    <table class="table table-bordered table-striped">
        <thead style="background-color:#343a40; color:white;">
            <tr>
                <th>Beautician</th>
                <th>Service</th>
                <th>Schedule</th>
                <th>
                    <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($beauticians_with_scheduled_appointments as $c)
                <tr id="{{ $c->appointment_id }}">
                    <td>{{ $c->firstname.' '.$c->middlename.' '.$c->lastname }}</td>
                    <td>
                        @php
                            $service_ids = DB::table('beautician_services')
                                        ->where('beautician_id','=',$c->beautician_id)
                                        ->select('service_id')
                                        ->get();
                            foreach ($service_ids as $service) {
                                $serv = HelperModel::GetSingle("services","service_id",$service->service_id);
                                echo $serv->service_name.' ';
                            }
                        @endphp
                    </td>
                    <td>
                        {!! date('M d, Y h:i A', strtotime($c->schedule)) !!}
                    </td>
                    <td>
                        <button class="btn btn-xs btn-success btnSetSchedule" title="Edit Customer">Set Schedule</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>