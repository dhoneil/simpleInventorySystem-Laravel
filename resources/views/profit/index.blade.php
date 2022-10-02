@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Profit')
@section('headertitle', 'Profit')

@section("maincontent")

	<div class="row">
		<div class="col-sm-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Date Range</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
								</span>
							</div>
							<input type="text" class="form-control float-right" id="saledaterange">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Revenues</h3>
				</div>
				<div class="card-body" id="profitlistarea">

				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Expenses</h3>
				</div>
				<div class="card-body" id="expenseslistarea">

				</div>
			</div>
			<div class="row">
				<div class="offset-md-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
							<i class="fas fa-text-width"></i>
								Total
							</h3>
						</div>
						<div class="card-body">
							<dl class="row">
							{{-- <dt class="col-sm-4">Revenue</dt>
							<dd class="col-sm-8" id="net_value_total_final">0.00</dd>
							<dt class="col-sm-4">Expenses</dt>
							<dd class="col-sm-8" id="amount_value_sales_total_final">0.00</dd> --}}
							<dt class="col-sm-8">Total Earnings</dt>
							<dd class="col-sm-4" id="total_final_earnings">0.00</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
	$(document).ready(function () {
		//Date range picker
    	$('#saledaterange').daterangepicker()

		function filterList() {
			var datefrom =  $('#saledaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
			var dateto =  $('#saledaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

			$.ajax({
				url:"{{ route('GetAllProfit') }}",
				method:'post',
				data:{
					_token : "{{ csrf_token() }}",
					datefrom : datefrom,
					dateto:dateto
				},
				success:function(res){
					$('#profitlistarea').html(res)
				}
			})

			$.ajax({
				url:"{{ route('GetAllExpenses') }}",
				method:'post',
				data:{
					_token : "{{ csrf_token() }}",
					datefrom : datefrom,
					dateto:dateto
				},
				success:function(res){
					$('#expenseslistarea').html(res)
				}
			})
		}

		function ComputeTotals() {
			var totalearnings = $('#net_value_total').text();
			$('#net_value_total_final').text(totalearnings);

			var totalExpenses = $('#amount_value_sales_total').text();
			$('#amount_value_sales_total_final').text(totalExpenses);

			// var total_final_earnings = parseFloat(totalearnings.replace(/,/g, '')) - parseFloat(totalExpenses.replace(/,/g, ''))
			var revenues_amount = $('#amount_value_total').text();
			var cost_value_total = $('#cost_value_total').text();
			var total_final_earnings = parseFloat(revenues_amount.replace(/,/g, '')) - parseFloat(cost_value_total.replace(/,/g, ''))
			$('#total_final_earnings').text(total_final_earnings)
		}

		$(document).on('change','#saledaterange',function () {
			filterList();

			setTimeout(function() { ComputeTotals(); }, 2000);


		})
	})
</script>


@endsection