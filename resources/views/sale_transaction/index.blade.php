@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Sale Transactions')
{{-- @section('headertitle', 'Items') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Sale Transaction Form</h3>

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
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Transaction Date</label>
                    <input type="date" class="form-control" id="transaction_date">
                  </div>
                  <div class="form-group">
                    <label for="">Item&nbsp;&nbsp;&nbsp;&nbsp;<span id="item_price_text">Price : <span id="item_price_value"></span></span></label>
                    <select id="item_id" class="form-control select2"></select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Qty</label>
                    <input type="number" class="form-control number" id="qty" min="0">
                  </div>
                  <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" class="form-control" id="amount" disabled>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Discount/Commission</label>
                    <input type="number" class="form-control number" id="discount_or_commission" min="0">
                  </div>
                  <div class="form-group">
                    <label for="">Net</label>
                    <input type="number" class="form-control" id="net" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
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

  <script type="text/javascript">

    $(document).ready(function() {



      let current_sale_transaction_id = 0;
      let current_transaction_date = "";

      $('#item_price_text').hide();
      getAll();
      getItems();
      resetTransDateToCurrentDate();


    function resetTransDateToCurrentDate() {
        var datenow = new Date().toDateInputValue();
        current_transaction_date = datenow;
        $('#transaction_date').val(datenow);
    }

	function CalculateNet() {
		$('#net').val("")
		var totalamount = $('#amount').val();
		var discount = $('#discount_or_commission').val();
		var net = parseFloat(totalamount) - parseFloat(discount)
		$('#net').val(net)
	}


    function getItems() {
        $.ajax({
            url:'{{ route("items_list_json") }}',
            method:'get',
            async : true,
            success:function (data) {
                var $dropdown = $("#item_id");
                $dropdown.append($("<option />").val("").text("[ SELECT ]"));
                $.each(data, function() {
                    $dropdown.append($("<option />").val(this.item_id).text(`${this.item_name} - ${this.item_description}`));
                });
                console.log(data)
                return data;
            }
        })
    }


      function getAll() {
        toggleLoadingModal(null,'show');
        $.ajax({
          url:'{{ route("SaleTransactions_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
        toggleLoadingModal(null,'hide');
      }

      function save(isdelete=false) {
        toggleLoadingModal('Saving Item','show');
        $.ajax({
          url:'{{ route("SaleTransactions_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "sale_transaction_id":current_sale_transaction_id,
            "isDelete":isdelete,
            'transaction_date':current_transaction_date,
            'item_id':$('#item_id :selected').val(),
            'qty':$('#qty').val(),
            'discount_or_commission':$('#discount_or_commission').val(),
            'net':$('#net').val(),
          },
          success:function(data){
            getAll()
          },
          error:function(data){
            toggleAlert('error','Error',data.responseJSON.message)
          }
        })
        current_sale_transaction_id=0;
        $("#transaction_date").prop('disabled', false);
        toggleLoadingModal('Saving Item','hide');
      }

      function clearAll() {
        resetTransDateToCurrentDate()
        $('#item_id option[value=""]').prop('selected', true);
        $('#qty').val('')
        $('#amount').val('')
        $('#discount_or_commission').val('')
        $('#net').val('')
      }

	  function getSingle() {
        $.ajax({
            url:'{{ route("SaleTransactions_single") }}',
            method:'post',
            data:{
            '_token':"{{ csrf_token() }}",
            'sale_transaction_id':current_sale_transaction_id,
            },
            success:function(data){
                populateForm(data)
                $("#transaction_date").prop('disabled', true);
            }
        })
	  }

	  function populateForm(data) {

        var date = new Date(data.sale_transaction.transaction_date * 1000);
        $('#transaction_date').val(date)
        current_transaction_date = data.sale_transaction.transaction_date;
        console.log(current_transaction_date)
        $('#item_id option[value='+data.sale_transaction.item_id+']').prop('selected', true);
        $('.select2').select2();
        $('#qty').val(data.sale_transaction.qty)
        $('#amount').val(data.sale_transaction.amount)
        $('#discount_or_commission').val(data.sale_transaction.discount_or_commission)
        $('#net').val(data.sale_transaction.net)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var sale_transaction_id = thiss.closest('tr').attr('id')
        current_sale_transaction_id = sale_transaction_id;
		    getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_sale_transaction_id = customer_id;
		if (confirm('Are you sure to delete this transaction?')) {
			save(true);
		}
      })

    $(document).on('change','#item_id',function (params) {
      var item_id = $('#item_id :selected').val();
      if (item_id != "") {
        toggleLoadingModal('Getting Item Price','show');
        $.ajax({
          url:'{{ route("items_single") }}',
            method:'post',
            data:{
            '_token':"{{ csrf_token() }}",
            'item_id':item_id,
            },
            success:function(data){
              if (data) {
                $('#item_price_text').show();
                $('#item_price_value').text(data.item.price);
              }
            }
        })
      }else{
        $('#qty').val('');
        $('#amount').val('');
        $('#item_price_text').hide();
      }
      toggleLoadingModal(null,'hide');
    })

    $(document).on('change','#qty',function (params) {
      var qty = $(this).val();
      var price = $('#item_price_value').text();
      var total_amount = parseFloat(qty) * parseFloat(price);
      $('#amount').val(total_amount);

    })

	$(document).on('change','#discount_or_commission',function(){
		CalculateNet();
	})



    });
  </script>
@stop


