@php
    use Illuminate\Support\Facades\DB;
    use App\Models\HelperModel;
@endphp

<table class="table table-bordered table-striped table-sm table-hover">
    <thead style="background-color:#343a40; color:white;">
        <tr>
            <th>Name</th>
            <th>Email/Username</th>
            <th>Role</th>
            <th>
                <i class="fas fa-cog"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $c)
            <tr id="{{ $c->id }}">
                <td>{{ $c->name }}</td>
                <td>{{ $c->email }}</td>
                <td>
                    @php
                        $role = HelperModel::GetSingle("user_roles","user_role_id",$c->role_id);
                        echo $role->role_name;
                    @endphp
                </td>
                <td>
                    <button class="btn btn-xs btn-success btnedit" title="Edit Customer"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger btndelete" title="Delete Customer"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>