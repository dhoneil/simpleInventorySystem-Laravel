<table class="table table-bordered table-striped table-sm table-hover itemledger">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $c)
            <tr id="{{ $c->item_id }}">
                <td class="created_at_value">{{ $c->created_at }}</td>
                <td>{{ $c->item_name.' '.$c->item_description }}</td>
                <td>{{ $c->qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>

    $(document).ready(function () {
        $('.itemledger').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "bDestroy": true
        });
    })

    $('.created_at_value').each(function() {
        var thiss = $(this)
        var val = thiss.text();
        var trans_date = moment(val).format('MMMM DD, YYYY')
        thiss.text(trans_date);
    });
</script>