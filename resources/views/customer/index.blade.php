@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Customers')
{{-- @section('headertitle', 'Customers') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Customer Form</h3>

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
            <label for="">First name</label>
            <input type="text" class="form-control" id="firstname">
          </div>
          <div class="form-group">
            <label for="">Middle name</label>
            <input type="text" class="form-control" id="middlename">
          </div>
          <div class="form-group">
            <label for="">Last name</label>
            <input type="text" class="form-control" id="lastname">
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
          <h3 class="card-title">Customers</h3>

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

      let current_customer_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("customers_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("customers_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "customer_id":current_customer_id,
            "isDelete":isdelete,
            'firstname':$('#firstname').val(),
            'middlename':$('#middlename').val(),
            'lastname':$('#lastname').val()
          },
          success:function(data){
            getAll()
          },
          error:function(data){
            toggleAlert('error','Error',data.responseJSON.message)
          }
        })
        current_customer_id=0;
      }

      function clearAll() {
        $('#firstname').val('')
        $('#middlename').val('')
        $('#lastname').val('')
      }

	  function getSingle() {
      $.ajax({
        url:'{{ route("Users_single") }}',
        method:'post',
        data:{
          '_token':"{{ csrf_token() }}",
          'id':current_customer_id,
        },
        success:function(data){
          populateForm(data)
        }
      })
	  }

	  function populateForm(data) {
	  	$('#firstname').val(data.user_information.firstname)
		$('#middlename').val(data.user_information.middlename)
		$('#lastname').val(data.user_information.lastname)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_customer_id = customer_id;
		    getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_customer_id = customer_id;
		if (confirm('Are you sure to delete this customer?')) {
			save(true);
		}
      })



    });
  </script>
@stop


