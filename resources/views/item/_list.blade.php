@php
    use Illuminate\Support\Facades\DB;
    use App\Models\HelperModel;
@endphp

<table class="table table-bordered table-striped table-sm table-hover" id="itemstable">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Genre</th>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Qty</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $c)
            <tr id="{{ $c->item_id }}">
                <td>{{ $c->item_genre_name }}</td>
                <td>{{ $c->item_code_name }}</td>
                <td>{{ $c->item_name }}</td>
                <td>{{ $c->item_description }}</td>
                <td>{{ $c->price }}</td>
                <td>
                    @php
                        $total_in = DB::table('purchase_transactions')
                                    ->join('items','items.item_id','=','purchase_transactions.item_id')
                                    ->where('purchase_transactions.item_id','=',$c->item_id)
                                    ->sum('purchase_transactions.qty');

                        $total_out = DB::table('sale_transactions')
                                    ->join('items','items.item_id','=','sale_transactions.item_id')
                                    ->where('sale_transactions.item_id','=',$c->item_id)
                                    ->sum('sale_transactions.qty');

                        $total_remaining = $total_in - $total_out;
                        echo $total_remaining;
                    @endphp
                </td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    {{-- <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button> --}}
                    <button class="btn btn-xs btn-primary btnitemledger" title="Item Ledger"><i class="fas fa-list"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#itemstable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    })
</script>