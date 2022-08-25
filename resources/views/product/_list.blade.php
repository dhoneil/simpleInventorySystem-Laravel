<table class="table table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $c)
            <tr id="{{ $c->product_id }}">
                <td>{{ $c->product_name }}</td>
                <td>{{ $c->product_price }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>