@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Beauticians')
{{-- @section('headertitle', 'Beauticians') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Beautician Form</h3>

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
          <div class="form-group">
            <label for="">Services</label>
            <select class="form-control select2 "multiple name="" id="services">
              <option value="">[ SELECT ]</option>
            </select>
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
          <h3 class="card-title">Beautician</h3>

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
      $('.select2').select2();

      let current_beautician_id = 0;

      getAll();
      getServices();

      function getAll() {
        $.ajax({
          url:'{{ route("beauticians_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function getServices() {
        $.ajax({
          url:'{{ route("Services_list_json") }}',
          method:'get',
          async : true,
          success:function (data) {
            var $dropdown = $("#services");
            $.each(data, function() {
                $dropdown.append($("<option />").val(this.service_id).text(`${this.service_name}`));
            });
            console.log(data)
            return data;
          }
        })
      }

      function save(isdelete=false) {
        console.log(isdelete)
        $.ajax({
          url:'{{ route("beauticians_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "beautician_id":current_beautician_id,
            "isDelete":isdelete,
            'firstname':$('#firstname').val(),
            'middlename':$('#middlename').val(),
            'lastname':$('#lastname').val(),
            'services' : $("#services").select2("val")
          },
          success:function(data){
            getAll()
          }
        })
        current_beautician_id=0;
      }

      function clearAll() {
        $('#firstname').val('')
        $('#middlename').val('')
        $('#lastname').val('')
      }

	  function getSingle() {
		  $.ajax({
        url:'{{ route("beauticians_single") }}',
        method:'post',
        data:{
          '_token':"{{ csrf_token() }}",
          'beautician_id':current_beautician_id,
        },
          success:function(data){
          populateForm(data)
        }
      })
	  }

	  function populateForm(data) {
	  	$('#firstname').val(data.firstname)
		$('#middlename').val(data.middlename)
		$('#lastname').val(data.lastname)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var beautician_id = thiss.closest('tr').attr('id')
        current_beautician_id = beautician_id;
		    getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var beautician_id = thiss.closest('tr').attr('id')
        current_beautician_id = beautician_id;
		if (confirm('Are you sure to delete this beautician?')) {
			save(true);
		}
      })



    });
  </script>
@stop


