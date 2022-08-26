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
                <td class="transaction_date_value">{{ $c->transaction_date }}</td>
                <td>{{ $c->item_name.' - '.$c->item_description}}</td>
                <td class="qty_value">{{ $c->qty }}</td>
                <td class="amount_value">{{ $c->amount }}</td>
                <td class="discount_or_commission_value">{{ $c->discount_or_commission }}</td>
                <td class="net_value">{{ $c->net }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    {{-- <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button> --}}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
            <td id="qty_value_total" style="font-weight: bold;"></td>
            <td id="amount_value_total" style="font-weight: bold;"></td>
            <td id="discount_or_commission_value_total" style="font-weight: bold;"></td>
            <td id="net_value_total" style="font-weight: bold;"></td>
        </tr>
    </tbody>
</table>

<script >
    $(document).ready(function (params) {


        $('.transaction_date_value').each(function() {
            var thiss = $(this)
            var val = thiss.text();
            var trans_date = moment(val).format('MMMM DD, YYYY')
            thiss.text(trans_date);
        });


        var sumqty = 0;
        $('.qty_value').each(function() {
            var thiss = $(this)
            var qty = parseFloat(thiss.text());
            var total = parseFloat(sumqty += qty);
            $('#qty_value_total').text(total).digits()
        });

        var sum_amount = 0;
        $('.amount_value').each(function() {
            var thiss = $(this)
            var amount = parseFloat(thiss.text());
            var total_amount = parseFloat(sum_amount += amount);
            $('#amount_value_total').text(total_amount).digits()
        });

        var discount_or_commission_value_total = 0;
        $('.discount_or_commission_value').each(function() {
            var thiss = $(this)
            var discountCommission = parseFloat(thiss.text());
            var discountcommission_total_amount = parseFloat(discount_or_commission_value_total += discountCommission);
            $('#discount_or_commission_value_total').text(discountcommission_total_amount).digits()
        });

        var net_value_total = 0;
        $('.net_value').each(function() {
            var thiss = $(this)
            var net_value = parseFloat(thiss.text());
            var net_valuetotal = parseFloat(net_value_total += net_value);
            $('#net_value_total').text(net_valuetotal).digits()
        });
    })
</script>