@extends("_layoutBookingSystem.bookingsystemlayout")
@section('title', 'Profit')
@section('headertitle', 'Profit')

@section("maincontent")

	<div class="row">
		<div class="col-sm-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Sale Date Range</h3>
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
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Net Profit</h3>
					</div>
					<div class="card-body" id="profitlistarea">

					</div>
				</div>
		</div>
	</div>

<script>
	$(document).ready(function () {
		//Date range picker
    	$('#saledaterange').daterangepicker()

		$(document).on('change','#saledaterange',function () {
			var datefrom =  $(this).data('daterangepicker').startDate.format('YYYY-MM-DD');
			var dateto =  $(this).data('daterangepicker').endDate.format('YYYY-MM-DD');

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
		})
	})
</script>


@endsection