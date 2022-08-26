<table class="table table-bordered table-striped table-sm table-hover">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $c)
            <tr id="{{ $c->service_id }}">
                <td>{{ $c->service_name }}</td>
                <td>{{ $c->service_price }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>