@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Users')
{{-- @section('headertitle', 'Users') --}}

@section("maincontent")
    <div class="row">
        <div hidden class="col-sm-3">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">User Form</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Firstname</label>
                        <input type="text" class="form-control" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="">Middlename</label>
                        <input type="txt" class="form-control" id="middlename">
                    </div>
                    <div class="form-group">
                        <label for="">Lastname</label>
                        <input type="txt" class="form-control" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="">E-mail/Username</label>
                        <input type="txt" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <select id="user_roles" class="form-control">
                            <option value="">[SELECT]</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="btnsave"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                </div>
                <div class="card-body" id="listarea" style="overflow-x: auto;overflow-y: auto; max-height:500px;">

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        (function () {
            let current_user_id = 0;

            getAll();
            getRoles()

            function getAll() {
                $.ajax({
                    url:'{{ route("Users_list") }}',
                    method:'get',
                    success:function (data) {
                        $('#listarea').html(data)
                    }
                })
            }

            function getRoles() {
                $.ajax({
                    url:'{{ route("UserRoles_list_json") }}',
                    method:'get',
                    success:function (data) {
                        var $dropdown = $("#user_roles");
                        $.each(data, function() {
                            $dropdown.append($("<option />").val(this.user_role_id).text(`${this.role_name}`));
                        });
                    }
                })
            }

			function clearAll() {
				$('#firstname').val('')
				$('#middlename').val('')
				$('#lastname').val('')
				$('#username').val('')
				$('#password').val('')
				$('#password').val('')
                $("#user_roles option").prop("selected", false);
			}

            function save(isdelete=false) {
                $.ajax({
					url:'{{ route("Users_create") }}',
					method:'post',
					data:{
						'_token':"{{ csrf_token() }}",
						"user_id":current_user_id,
						"isDelete":isdelete,
						'firstname':$('#firstname').val(),
						'middlename':$('#middlename').val(),
						'lastname':$('#lastname').val(),
						'username':$('#username').val(),
						'password':$('#password').val(),
                        'role_id' : $('#user_roles :selected').val(),
					},
					success:function(data){
                        console.log(data)
						getAll()
					}
                })
                current_user_id=0;
            }

			function getSingle() {
				$.ajax({
					url:'{{ route("Users_single") }}',
					method:'post',
					data:{
						'_token':"{{ csrf_token() }}",
						'id':current_user_id,
					},
					success:function(data){
                        console.log(data)
                        clearAll();
						populateForm(data)
					}
				})
			}

			function populateForm(data) {
				$('#firstname').val(data.user_information.firstname)
				$('#middlename').val(data.user_information.middlename)
				$('#lastname').val(data.user_information.lastname)
				$('#username').val(data.user.email)
				$('#password').val(data.user.password)
                $('#user_roles option[value='+data.user.role_id+']').prop('selected', true);
			}

			$(document).on('click','#btnsave',function () {
				save();
				clearAll();
			})

			$(document).on('click','.btnedit',function () {
				var thiss = $(this);
				var user_id = thiss.closest('tr').attr('id')
				current_user_id = user_id;
				getSingle();
			})

            $(document).on('click','.btndelete',function () {
                var thiss = $(this);
                var user_id = thiss.closest('tr').attr('id')
                current_user_id = user_id;
                if (confirm('Are you sure to delete this User?')) {
                    save(true);
                }
            })



        })();
    </script>

@endsection