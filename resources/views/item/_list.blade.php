<table class="table table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $c)
            <tr id="{{ $c->item_id }}">
                <td>{{ $c->item_name }}</td>
                <td>{{ $c->item_description }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>