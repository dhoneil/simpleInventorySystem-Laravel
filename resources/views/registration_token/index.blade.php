@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Products')
{{-- @section('headertitle', 'Products') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Token Form</h3>

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
            <label for="">Token</label>
            <input type="text" class="form-control" id="token">
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-success" id="btnsave"><i class="fas fa-save"></i> Save</button>
          <button class="btn btn-primary" id="btngeneratetoken"><i class="fas fa-save"></i> Generate Token</button>
        </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tokens</h3>

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

      let current_registration_token_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("registration_tokens_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

	  function generate_token() {
		$.ajax({
		  url:"{{ route('generate_token') }}",
		  method:'get',
		  success:function(data){
		    $('#token').val(data)
		  }
		})
	  }

      function save(isdelete=false) {
        console.log(isdelete)
        $.ajax({
          url:'{{ route("registration_tokens_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "registration_token_id":current_registration_token_id,
            "isDelete":isdelete,
            'token':$('#token').val(),
          },
          success:function(data){
            if (data == 1) {
				getAll()
			}
          }
        })
        current_registration_token_id=0;
      }

      function clearAll() {
        $('#token').val('')
      }

	  function getSingle() {
		$.ajax({
          url:'{{ route("registration_tokens_single") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            'registration_token_id':current_registration_token_id,
          },
          success:function(data){
			populateForm(data)
          }
        })
	  }

	  function populateForm(data) {
	  	$('#token').val(data.token)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

	  $(document).on('click','#btngeneratetoken',function () {
	    generate_token()
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var registration_token = thiss.closest('tr').attr('id')
        current_registration_token_id = registration_token;
		getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var registration_token = thiss.closest('tr').attr('id')
        current_registration_token_id = registration_token;
		if (confirm('Are you sure to delete this product?')) {
			save(true);
		}
      })



    });
  </script>
@stop


