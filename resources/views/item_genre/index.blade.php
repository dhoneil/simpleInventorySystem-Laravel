@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Item genres')
{{-- @section('headertitle', 'Items') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Item Genre Form</h3>

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
            <label for="">Item Genre Name</label>
            <input type="text" class="form-control" id="item_genre_name">
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
        <div class="card-body" id="listarea" style="overflow-x: auto;overflow-y: auto; max-height:500px;">

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      let current_item_genre_id = 0;

      getAll();

      function getAll() {
        $.ajax({
          url:'{{ route("ItemGenres_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("ItemGenres_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "item_genre_id":current_item_genre_id,
            "isDelete":isdelete,
            'item_genre_name':$('#item_genre_name').val()
          },
          success:function(data){
            getAll()
          }
        })
        current_item_genre_id=0;
      }

      function clearAll() {
        $('#item_genre_name').val('')
      }

	  function getSingle() {
        $.ajax({
            url:'{{ route("ItemGenres_single") }}',
            method:'post',
            data:{
            '_token':"{{ csrf_token() }}",
            'item_genre_id':current_item_genre_id,
            },
            success:function(data){
                populateForm(data)
            }
        })
	  }

	  function populateForm(data) {
	  	$('#item_genre_name').val(data.item_genre.item_genre_name)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var item_genre_id = thiss.closest('tr').attr('id')
        current_item_genre_id = item_genre_id;
		getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_item_genre_id = customer_id;
		if (confirm('Are you sure to delete this item genre?')) {
			save(true);
		}
      })



    });
  </script>
@stop


