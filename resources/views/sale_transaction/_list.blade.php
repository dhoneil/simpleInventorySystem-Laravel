<table class="table table-sm table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Discount / Commission</th>
            <th>Net</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sale_transactions as $c)
            <tr id="{{ $c->sale_transaction_id }}">
                <td>{{ $c->transaction_date }}</td>
                <td>{{ $c->item_id }}</td>
                <td>{{ $c->qty }}</td>
                <td>{{ $c->amount }}</td>
                <td>{{ $c->discount_or_commission }}</td>
                <td>{{ $c->net }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    {{-- <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>