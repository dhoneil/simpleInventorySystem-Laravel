@php
    use Illuminate\Support\Facades\DB;
    use App\Models\HelperModel;
@endphp


<table class="table table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Name</th>
            <th>Services</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($beauticians as $c)
            <tr id="{{ $c->beautician_id }}">
                <td>{{ $c->firstname }} {{ $c->middlename }} {{ $c->lastname }}</td>
                <td>
                    @php
                        $service_ids = DB::table('beautician_services')
                                    ->where('beautician_id','=',$c->beautician_id)
                                    ->select('service_id')
                                    ->get();
                        foreach ($service_ids as $service) {
                            $serv = HelperModel::GetSingle("services","service_id",$service->service_id);
                            echo $serv->service_name.', ';
                        }
                    @endphp
                </td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>