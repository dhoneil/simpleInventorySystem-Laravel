<table class="table table-sm table-bordered table-striped table-hover" id="purchasetransactiontable">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Cost</th>
            <th>Qty</th>
            <th>Delivery Fee</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchase_transactions as $c)
            <tr id="{{ $c->purchase_transaction_id }}" {{ $c->price }} {{ $c->qty }}>
                <td class="transaction_date_value">{{ $c->transaction_date }}</td>
                <td>{{ $c->item_name.' - '.$c->item_description}}</td>
                <td class="cost_value">{{$c->cost}}</td>
                <td class="qty_value">{{ $c->qty }}</td>
                <td class="delivery_fee_value">{{ $c->delivery_fee }}</td>
                <td class="amount_value_sales">
                    @php
                        $cost = $c->cost;
                        $qty = $c->qty;
                        $delivery_fee = $c->delivery_fee;
                        $amount = ($cost * $qty) + $delivery_fee;
                        echo $amount;
                    @endphp
                </td>
            </tr>
        @endforeach
            <tr>
                <td id="" style="font-weight: bold;"></td>
                <td id="" style="font-weight: bold;"></td>
                <td id="cost_value_total" style="font-weight: bold;"></td>
                <td id="qty_value_total" style="font-weight: bold;"></td>
                <td id="delivery_fee_value_total" style="font-weight: bold;"></td>
                <td id="amount_value_sales_total" style="font-weight: bold; color:green;"></td>
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

        var sumdeliveryfee = 0;
        $('.delivery_fee_value').each(function() {
            var thiss = $(this)
            var qty = parseFloat(thiss.text());
            var total = parseFloat(sumdeliveryfee += qty);
            $('#delivery_fee_value_total').text(total).digits()
        });

        var sumcost = 0;
        $('.cost_value').each(function() {
            var thiss = $(this)
            var qty = parseFloat(thiss.text());
            var total = parseFloat(sumcost += qty);
            $('#cost_value_total').text(total).digits()
        });


        var sumqty = 0;
        $('.qty_value').each(function() {
            var thiss = $(this)
            var qty = parseFloat(thiss.text());
            var total = parseFloat(sumqty += qty);
            $('#qty_value_total').text(total).digits()
        });

        var sum_amount_value_sales = 0;
        $('.amount_value_sales').each(function() {
            var thiss = $(this)
            var amount = parseFloat(thiss.text());
            var total_amount = parseFloat(sum_amount_value_sales += amount);
            $('#amount_value_sales_total').text(total_amount).digits()
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