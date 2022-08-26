<table class="table table-bordered table-striped table-sm table-hover">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Genre</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($item_genres as $c)
            <tr id="{{ $c->item_genre_id }}">
                <td>{{ $c->item_genre_name }}</td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>