@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Items')
{{-- @section('headertitle', 'Items') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Item Form</h3>

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
            <label for="">Item Name</label>
            <input type="text" class="form-control" id="item_name">
          </div>
          <div class="form-group">
            <label for="">Item Description</label>
            <input type="text" class="form-control" id="item_description">
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
          <h3 class="card-title">List</h3>

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

      let current_item_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("Items_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("items_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "item_id":current_item_id,
            "isDelete":isdelete,
            'item_name':$('#item_name').val(),
            'item_description':$('#item_description').val()
          },
          success:function(data){
            getAll()
          }
        })
        current_item_id=0;
      }

      function clearAll() {
        $('#item_name').val('')
        $('#item_description').val('')
      }

	  function getSingle() {
        $.ajax({
            url:'{{ route("items_single") }}',
            method:'post',
            data:{
            '_token':"{{ csrf_token() }}",
            'item_id':current_item_id,
            },
            success:function(data){
                populateForm(data)
            }
        })
	  }

	  function populateForm(data) {
	  	$('#item_name').val(data.item.item_name)
		$('#item_description').val(data.item.item_description)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var item_id = thiss.closest('tr').attr('id')
        current_item_id = item_id;
		getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_item_id = customer_id;
		if (confirm('Are you sure to delete this item?')) {
			save(true);
		}
      })



    });
  </script>
@stop


