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
                    <label for="">Item</label>
                    <select id="item_id" class="form-control select2"></select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Qty</label>
                    <input type="number" class="form-control" id="qty">
                  </div>
                  <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" class="form-control" id="amount">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Discount/Commission</label>
                    <input type="number" class="form-control" id="discount_or_commission">
                  </div>
                  <div class="form-group">
                    <label for="">Net</label>
                    <input type="number" class="form-control" id="net">
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

    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });

    $(document).ready(function() {

      let current_sale_transaction_id = 0;

      getAll();
      getItems();
      resetTransDateToCurrentDate();


    function resetTransDateToCurrentDate() {
        $('#transaction_date').val(new Date().toDateInputValue());
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
          url:'{{ route("SaleTransactions_list") }}',
          method:'get',
          success:function (data) {
            $('#listarea').html(data)
          }
        })
      }

      function save(isdelete=false) {
        $.ajax({
          url:'{{ route("SaleTransactions_create") }}',
          method:'post',
          data:{
            '_token':"{{ csrf_token() }}",
            "sale_transaction_id":current_sale_transaction_id,
            "isDelete":isdelete,
            'transaction_date':$('#transaction_date').val(),
            'item_id':$('#item_id :selected').val(),
            'qty':$('#qty').val(),
            'amount':$('#amount').val(),
            'discount_or_commission':$('#discount_or_commission').val(),
            'net':$('#net').val(),
          },
          success:function(data){
            getAll()
          }
        })
        current_sale_transaction_id=0;
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
            }
        })
	  }

	  function populateForm(data) {

        var date = new Date(data.sale_transaction.transaction_date * 1000);
        $('#transaction_date').val(date)
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



    });
  </script>
@stop


