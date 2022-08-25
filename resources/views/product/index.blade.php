@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Products')
{{-- @section('headertitle', 'Products') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Product Form</h3>

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
            <label for="">Product</label>
            <input type="text" class="form-control" id="product_name">
          </div>
          <div class="form-group">
            <label for="">Price</label>
            <input type="number" class="form-control" id="product_price">
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
          <h3 class="card-title">Products</h3>

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

      let current_product_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("Products_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        console.log(isdelete)
        $.ajax({
          url:'{{ route("Products_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "product_id":current_product_id,
            "isDelete":isdelete,
            'product_name':$('#product_name').val(),
            'product_price':$('#product_price').val()
          },
          success:function(data){
            getAll()
          }
        })
        current_product_id=0;
      }

      function clearAll() {
        $('#product_name').val('')
        $('#product_price').val('')
      }

	  function getSingle() {
		$.ajax({
          url:'{{ route("Products_single") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            'product_id':current_product_id,
          },
          success:function(data){
			populateForm(data)
          }
        })
	  }

	  function populateForm(data) {
	  	$('#product_name').val(data.product_name)
		$('#product_price').val(data.product_price)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var product_id = thiss.closest('tr').attr('id')
        current_product_id = product_id;
		getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var beautician_id = thiss.closest('tr').attr('id')
        current_product_id = beautician_id;
		if (confirm('Are you sure to delete this product?')) {
			save(true);
		}
      })



    });
  </script>
@stop


