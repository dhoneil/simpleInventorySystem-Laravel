@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Appointment')
{{-- @section('headertitle', 'Appointment') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Appointment Form</h3>

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
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Customer</label>
                <select name="" id="customers" class="form-control">
                  <option value="">[SELECT]</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Beauticians</label>
                <select name="" id="beauticians" class="form-control">
                  <option value="">[SELECT]</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Services</label>
                <select name="" id="services" class="form-control">
                  <option value="">[SELECT]</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Products</label>
                <select name="" id="products" class="form-control">
                  <option value="">[SELECT]</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Appointment Status</label>
                <select name="" id="appointment_status" class="form-control">
                  <option value="">[SELECT]</option>
                  <option value="PENDING" selected>PENDING</option>
                  <option value="ON-GOING">ON-GOING</option>
                  <option value="CANCELLED">CANCELLED</option>
                  <option value="DONE">DONE</option>
                </select>
              </div>
              <div class="form-group">
                <label>Schedule</label>
                  <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                  <input type="text" id="schedule" class="form-control datetimepicker-input" data-target="#reservationdatetime">
                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                </div>
              </div>
            </div>
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
          <h3 class="card-title">Appointments</h3>

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

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

      let current_Appointment_id = 0;

      getAll();
      getCustomers()
      getBeauticians()
      getServices()
      getProducts()

      function getAll() {
        $.ajax({
          url:'{{ route("Appointments_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function getCustomers() {
        $.ajax({
          url:'{{ route("customers_list_json") }}',
          method:'get',
          success:function (data) {
            var $dropdown = $("#customers");
            $.each(data, function() {
                $dropdown.append($("<option />").val(this.customer_id).text(`${this.firstname} ${this.lastname}`));
            });
          }
        })
      }

      function getBeauticians() {
        $.ajax({
          url:'{{ route("beauticians_list_json") }}',
          method:'get',
          success:function (data) {
            var $dropdown = $("#beauticians");
            $.each(data, function() {
                $dropdown.append($("<option />").val(this.beautician_id).text(`${this.firstname} ${this.lastname}`));
            });
          }
        })
      }

      function getServices() {
        $.ajax({
          url:'{{ route("Services_list_json") }}',
          method:'get',
          success:function (data) {
            var $dropdown = $("#services");
            $.each(data, function() {
                $dropdown.append($("<option />").val(this.service_id).text(`${this.service_name} ${this.service_price}`));
            });
          }
        })
      }

      function getProducts() {
        $.ajax({
          url:'{{ route("Products_list_json") }}',
          method:'get',
          success:function (data) {
            var $dropdown = $("#products");
            $.each(data, function() {
                $dropdown.append($("<option />").val(this.product_id).text(`${this.product_name} ${this.product_price}`));
            });
          }
        })
      }

	function save(isdelete=false) {
		let flag = true;
		if ($('#customers').find(":selected").val() == "") {
			alert('Please select a customer')
			flag = false;
		}
		if ($('#beauticians').find(":selected").val() == "") {
			alert('Please select a beautcian')
			flag = false;
		}
		if ($('#services').find(":selected").val() == "") {
			alert('Please select a service')
			flag = false;
		}
		if ($('#products').find(":selected").val() == "") {
			alert('Please select a product')
			flag = false;
		}
		if ($('#schedule').val() == "") {
			alert('Please select a schedule')
		}
		if (flag) {
			$.ajax({
				url:'{{ route("Appointments_create") }}',
				method:'post',
				data:{
					'_token':"{{ csrf_token() }}",
					"appointment_id":current_Appointment_id,
					"isDelete":isdelete,
					"customer_id":$('#customers').find(":selected").val(),
					"beautician_id":$('#beauticians').find(":selected").val(),
					'service_id':$('#services').find(":selected").val(),
					'product_id':$('#products').find(":selected").val(),
					'schedule':$('#schedule').val(),
					'total_amount':200,
					'appointment_status' : $('#appointment_status').find(":selected").val()
				},
				success:function(data){
					getAll()
				}
			})
		}

		current_Appointment_id=0;
		clearAll();
	}

	function clearAll() {
		$("#customers option").prop("selected", false);
		$("#beauticians option").prop("selected", false);
		$("#services option").prop("selected", false);
		$("#products option").prop("selected", false);
		$('#schedule').val('');
	}

	function getSingle() {
		$.ajax({
			url:'{{ route("Appointments_single") }}',
			method:'post',
			data:{
				'_token':"{{ csrf_token() }}",
				'appointment_id':current_Appointment_id,
			},
			success:function(data){
				populateForm(data)
			}
		})
	}

	Date.prototype.addHours= function(h){
		this.setHours(this.getHours()+h);
		return this;
	}

	function populateForm(data) {
	  	console.log(data)
	  	$('#customers option[value='+data.customer_id+']').prop('selected', true);
	  	$('#beauticians option[value='+data.beautician_id+']').prop('selected', true);
	  	$('#services option[value='+data.service_id+']').prop('selected', true);
	  	$('#products option[value='+data.product_id+']').prop('selected', true);

		//for some reason time is behind 4 hrs so need to add hrs
		const str = moment(new Date(data.schedule).addHours(4)).format('MM/DD/yyyy h:mm a');
		$('#schedule').val(str);
	}

	$(document).on('click','#btnsave',function () {
		save();
		clearAll();
	})

	$(document).on('click','.btnedit',function () {
		var thiss = $(this);
		var Service_id = thiss.closest('tr').attr('id')
		current_Appointment_id = Service_id;
		getSingle();
	})

	$(document).on('click','.btndelete',function () {
		var thiss = $(this);
		var Service_id = thiss.closest('tr').attr('id')
		current_Appointment_id = Service_id;
		if (confirm('Are you sure to delete this Service?')) {
			save(true);
		}
	})



    });
  </script>
@stop


