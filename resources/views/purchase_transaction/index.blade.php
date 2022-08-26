@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Purchase Transactions')
{{-- @section('headertitle', 'Items') --}}

@section("maincontent")
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Purchase Transaction Form</h3>

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
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Item&nbsp;&nbsp;&nbsp;&nbsp;<span id="item_price_text">Price : <span id="item_price_value"></span></span></label>
                        <select id="item_id" class="form-control select2"></select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Qty</label>
                        <input type="number" class="form-control" id="qty">
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

      let current_purchase_transaction_id = 0;
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
        $.ajax({
          url:'{{ route("PurchaseTransactions_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("PurchaseTransactions_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "purchase_transaction_id":current_purchase_transaction_id,
            "isDelete":isdelete,
            'transaction_date':current_transaction_date,
            'item_id':$('#item_id :selected').val(),
            'qty':$('#qty').val(),
          },
          success:function(data){
            getAll()
          }
        })
        current_purchase_transaction_id=0;
        $("#transaction_date").prop('disabled', false);
      }

      function clearAll() {
        resetTransDateToCurrentDate()
        $('#item_id option[value=""]').prop('selected', true);
        $('.select2').select2()
        $('#qty').val('')
      }

	  function getSingle() {
        $.ajax({
            url:'{{ route("PurchaseTransactions_single") }}',
            method:'post',
            data:{
            '_token':"{{ csrf_token() }}",
            'purchase_transaction_id':current_purchase_transaction_id,
            },
            success:function(data){
                populateForm(data)
                $("#transaction_date").prop('disabled', true);
            }
        })
	  }

	  function populateForm(data) {

        var date = new Date(data.purchase_transaction.transaction_date * 1000);
        $('#transaction_date').val(date)
        current_transaction_date = data.purchase_transaction.transaction_date;
        console.log(current_transaction_date)
        $('#item_id option[value='+data.purchase_transaction.item_id+']').prop('selected', true);
        $('.select2').select2();
        $('#qty').val(data.purchase_transaction.qty)
	  }

      $(document).on('click','#btnsave',function () {
        save();
        clearAll();
      })

      $(document).on('click','.btnedit',function () {
        var thiss = $(this);
        var purchase_transaction_id = thiss.closest('tr').attr('id')
        current_purchase_transaction_id = purchase_transaction_id;
		    getSingle();
      })

	  $(document).on('click','.btndelete',function () {
        var thiss = $(this);
        var customer_id = thiss.closest('tr').attr('id')
        current_purchase_transaction_id = customer_id;
		if (confirm('Are you sure to delete this transaction?')) {
			save(true);
		}
      })

    $(document).on('change','#item_id',function (params) {
      var item_id = $('#item_id :selected').val();
      if (item_id != "") {
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
        $('#item_price_text').hide();
      }
    })

    $(document).on('change','#qty',function (params) {
      var qty = $(this).val();
      var price = $('#item_price_value').text();
      var total_amount = parseFloat(qty) * parseFloat(price);
      $('#amount').val(total_amount);

    })



    });
  </script>
@stop


