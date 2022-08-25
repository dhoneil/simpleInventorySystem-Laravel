@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Services')
{{-- @section('headertitle', 'Services') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Service Form</h3>

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
            <label for="">Service</label>
            <input type="text" class="form-control" id="service_name">
          </div>
          <div class="form-group">
            <label for="">Price</label>
            <input type="number" class="form-control" id="service_price">
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
          <h3 class="card-title">Services</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body" id="listarea">

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      let current_Service_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("Services_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("Services_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "service_id":current_Service_id,
            "isDelete":isdelete,
            'service_name':$('#service_name').val(),
            'service_price':$('#service_price').val(),
          },
          success:function(data){
            getAll()
          }
        })
        current_Service_id=0;
      }

      function clearAll() {
        $('#service_name').val('')
        $('#service_price').val('')
      }

	  function getSingle() {
      $.ajax({
        url:'{{ route("Services_single") }}',
        method:'post',
        data:{
          '_token':"{{ csrf_token() }}",
          'service_id':current_Service_id,
        },
        success:function(data){
          populateForm(data)
        }
      })
	  }

	  function populateForm(data) {
	  	$('#service_name').val(data.service_name)
		  $('#service_price').val(data.service_price)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var Service_id = thiss.closest('tr').attr('id')
        current_Service_id = Service_id;
		    getSingle();
      })

	  $(document).on('click','.btndelete',function () {
      var thiss = $(this);
      var Service_id = thiss.closest('tr').attr('id')
      current_Service_id = Service_id;
      if (confirm('Are you sure to delete this Service?')) {
        save(true);
      }
    })



    });
  </script>
@stop


