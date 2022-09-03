@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Items')
{{-- @section('headertitle', 'Items') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-12">
      <div class="card" id="itemformcard">
        <div class="card-header">
          <h3 class="card-title">Item Form</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <label for="">Item Genre</label>
                  <select id="item_genre_id" class="form-control select2"></select>
                </div>
                <div class="form-group">
                  <label for="">Item Code</label>
                  <select id="item_code_id" class="form-control select2"></select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="">Item Name</label>
                  <input type="text" class="form-control" id="item_name">
                </div>
                <div class="form-group">
                  <label for="">Item Description</label>
                  <input type="text" class="form-control" id="item_description">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="">Price</label>
                  <input type="number" min="0" class="form-control" id="price">
                </div>
                <div class="form-group">
                  <label for="">&nbsp;</label>
                  <br>
                  <button class="btn btn-success btn-block" id="btnsave"><i class="fas fa-save"></i> Save</button>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12">
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


	<div class="modal fade" id="itemledgermodal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Item Ledger</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body itemledgermodalbody">
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<span>In</span>
								</div>
								<div class="card-body" id="itemsinarea" style="overflow-x: auto; overflow-y:auto; max-height:500px;">

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<span>Out</span>
								</div>
								<div class="card-body" id="itemsoutarea" style="overflow-x: auto; overflow-y:auto; max-height:500px;">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  <script type="text/javascript">
    $(document).ready(function() {

      let current_item_id = 0;

      getAll();
      getItemCodes()
      getItemGenres()
      // toggleitemformcard("hide")

      function toggleitemformcard(cardaction) {
        if (cardaction=="show") {
          $('#itemformcard').removeClass("collapsed-card");
        }
        if (cardaction=="hide") {
          $('#itemformcard').addClass("collapsed-card");
        }
      }

      function getAll() {
        $.ajax({
          url:'{{ route("Items_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function getItemCodes() {
          $.ajax({
              url:'{{ route("ItemCodes_list_json") }}',
              method:'get',
              async : true,
              success:function (data) {
                  var $dropdown = $("#item_code_id");
                  $dropdown.append($("<option />").val("").text("[ SELECT ]"));
                  $.each(data, function() {
                      $dropdown.append($("<option />").val(this.item_code_id).text(`${this.item_code_name}`));
                  });
                  console.log(data)
                  return data;
              }
          })
      }

      function getItemGenres() {
          $.ajax({
              url:'{{ route("ItemGenres_list_json") }}',
              method:'get',
              async : true,
              success:function (data) {
                  var $dropdown = $("#item_genre_id");
                  $dropdown.append($("<option />").val("").text("[ SELECT ]"));
                  $.each(data, function() {
                      $dropdown.append($("<option />").val(this.item_genre_id).text(`${this.item_genre_name}`));
                  });
                  console.log(data)
                  return data;
              }
          })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("items_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "item_code_id":$('#item_code_id :selected').val(),
            "item_genre_id":$('#item_genre_id :selected').val(),
            "item_id":current_item_id,
            "isDelete":isdelete,
            'item_name':$('#item_name').val(),
            'item_description':$('#item_description').val(),
            'price':$('#price').val(),
          },
          success:function(data){
            getAll()
            clearAll();
          },
          error:function(data){
            console.log(data)
            toggleAlert('error','Error',data.responseJSON.message)
          }
        })
        current_item_id=0;
      }

      function clearAll() {
        $('#item_code_id option[value=""]').prop('selected', true);
        $('#item_genre_id option[value=""]').prop('selected', true);
        $('.select2').select2();
        $('#item_name').val("")
        $('#item_description').val("")
        $('#price').val("")
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
      $('#item_code_id option[value='+data.item.item_code_id+']').prop('selected', true);
      $('#item_genre_id option[value='+data.item.item_genre_id+']').prop('selected', true);
      $('.select2').select2();
	  	$('#item_name').val(data.item.item_name)
		  $('#item_description').val(data.item.item_description)
		  $('#price').val(data.item.price)
	  }

      $(document).on('click','#btnsave',function () {
        // toggleitemformcard("hide")
        save();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var item_id = thiss.closest('tr').attr('id')
        current_item_id = item_id;
		    getSingle();
        // toggleitemformcard("show")
      })

	  $(document).on('click','.btndelete',function () {
      var thiss = $(this);
          var item_id = thiss.closest('tr').attr('id')
          current_item_id = item_id;
      if (confirm('Are you sure to delete this item?')) {
        save(true);
      }
    })

    $(document).on('click','.btnitemledger',function () {
    	var thiss = $(this);
    	var item_id = thiss.closest('tr').attr('id')
    	current_item_id = item_id;
		getInOutItems(current_item_id,1);
		getInOutItems(current_item_id,2);
		$('#itemledgermodal').modal('show')
    })

	function getInOutItems(item_id, transaction_type) {
		$.ajax({
			url:'{{ route("ItemInOutList") }}',
			method:'post',
			data:{
				'_token' : "{{ csrf_token() }}",
				'item_id' : item_id,
				'transaction_type' : transaction_type,
			},
			success:function (data) {
				if (transaction_type == 1) {
					$('#itemsinarea').html(data)
				}
				if (transaction_type == 2) {
					$('#itemsoutarea').html(data)
				}
			}
        })
	}





    });
  </script>
@stop


