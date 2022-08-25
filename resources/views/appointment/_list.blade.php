@php
    use Illuminate\Support\Facades\DB;
    use App\Models\HelperModel;
@endphp

<table class="table table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Customer</th>
            <th>Beautician</th>
            <th>Service</th>
            <th>Product</th>
            <th>Schedule</th>
            <th>Total</th>
            <th>Status</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($appointments as $c)
            <tr id="{{ $c->appointment_id }}">
                <td>
                    @php
                        $cust = HelperModel::GetSingle("customers","customer_id",$c->customer_id);
                        echo $cust->firstname.' '.$cust->middlename.' '.$cust->lastname;
                    @endphp
                </td>
                <td>
                    @php
                        $beau = HelperModel::GetSingle("beauticians","beautician_id",$c->beautician_id);
                        echo $beau->firstname.' '.$beau->middlename.' '.$beau->lastname;
                    @endphp
                </td>
                <td>
                    @php
                        $serv = HelperModel::GetSingle("services","service_id",$c->service_id);
                        echo $serv->service_name;
                    @endphp
                </td>
                <td>
                    @php
                        $serv = HelperModel::GetSingle("products","product_id",$c->product_id);
                        echo $serv->product_name;
                    @endphp
                </td>
                <td>
                    @php
                        $currentDateTime = $c->schedule;
                        $newDateTime = date('M/d/y h:i A', strtotime($currentDateTime));
                        echo $newDateTime;
                    @endphp
                </td>
                <td>
                    {{ $c->total_amount }}
                </td>
                <td>
                    {{ $c->appointment_status }}
                </td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    (function () {

    })();
</script>