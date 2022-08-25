<table class="table table-bordered table-striped">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Token</th>
            {{-- <th>
                <i class="fas fa-cog"></i>
            </th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($registration_tokens as $c)
            <tr id="{{ $c->registration_token_id }}">
                <td>{{ $c->token }}</td>
                {{-- <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>