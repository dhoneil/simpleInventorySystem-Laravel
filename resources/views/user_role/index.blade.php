@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'User Roles')
{{-- @section('headertitle', 'User Roles') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">User Role Form</h3>

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
            <label for="">Role Name</label>
            <input type="text" class="form-control" id="role_name">
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-success" id="btnsave"><i class="fas fa-save"></i> Save</button>
        </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">User Roles</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body" id="listarea" style="overflow-x: auto;overflow-y: auto; max-height:500px;">

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      let current_user_role_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("UserRoles_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("UserRoles_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "user_role_id":current_user_role_id,
            "isDelete":isdelete,
            'role_name':$('#role_name').val(),
          },
          success:function(data){
            getAll()
          },
          error:function(data){
            toggleAlert('error','Error',data.responseJSON.message)
          }
        })
        current_user_role_id=0;
      }

      function clearAll() {
        $('#role_name').val('')
      }

	  function getSingle() {
		$.ajax({
          url:'{{ route("UserRoles_single") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            'user_role_id':current_user_role_id,
          },
          success:function(data){
			populateForm(data)
          }
        })
	  }

	  function populateForm(data) {
	  	$('#role_name').val(data.role_name)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var role_id = thiss.closest('tr').attr('id')
        current_user_role_id = role_id;
		getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var role_id = thiss.closest('tr').attr('id')
        current_user_role_id = role_id;
		if (confirm('Are you sure to delete this customer?')) {
			save(true);
		}
      })



    });
  </script>
@stop


