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
            <th>Cost</th>
            <th>Purchased</th>
            <th>Sold</th>
            <th>Profit</th>
            <th>Avail. (Qty)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $c)
            @php
                $total_purchased = DB::table('purchase_transactions')
                            ->join('items','items.item_id','=','purchase_transactions.item_id')
                            ->where('purchase_transactions.item_id','=',$c->item_id)
                            ->sum('purchase_transactions.qty');

                $total_sold = DB::table('sale_transactions')
                            ->join('items','items.item_id','=','sale_transactions.item_id')
                            ->where('sale_transactions.item_id','=',$c->item_id)
                            ->sum('sale_transactions.qty');

                $item_cost = DB::table('purchase_transactions')
                            ->join('items','items.item_id','=','purchase_transactions.item_id')
                            ->where('purchase_transactions.item_id','=',$c->item_id)
                            ->sum('purchase_transactions.cost');
            @endphp
            <tr id="{{ $c->item_id }}">
                <td>{{ $c->item_genre_name }}</td>
                <td>{{ $c->item_code_name }}</td>
                <td>{{ $c->item_name }}</td>
                <td>{{ $item_cost }}</td>
                <td>{{ $total_purchased }}</td>
                <td>{{ $total_sold }}</td>
                <td>
                    @php
                        $profit = $item_cost * $total_sold;
                        echo $profit
                    @endphp
                </td>
                <td>
                    @php
                        $total_remaining = $total_purchased - $total_sold;
                        echo $total_remaining;
                    @endphp
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