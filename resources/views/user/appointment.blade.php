@extends("_layoutBookingSystem.bookingsystemlayout_external")
@section('title', 'Appointment')
@section('headertitle', 'Create an appointment')

@section('maincontent')
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Schedules</h3>
            </div>
            <div class="card-body" id="beauticianlistarea">

            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Schedules</h3>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</div>

<script>
    let current_appointment_id;
    getBeauticians();
    function getBeauticians(params) {
        $.ajax({
            url:"{{ route('user_get_beauticians') }}",
            method:'get',
            success:function(data){
                $('#beauticianlistarea').html(data)
            }
        })
    }

    function populateForm(data) {
        $('#service_name').val(data.service_name)
        $('#service_price').val(data.service_price)
    }

    function getSingle(tablename="",columnname="",columnvalue="") {
        $.ajax({
            url:'{{ route("get_single_json") }}',
            method:'post',
            data:{
                '_token':"{{ csrf_token() }}",
                tablename:tablename,
                column:columnname,
                columnvalue:columnvalue,
            },
            success:function(data){
                populateForm(data)
            }
        })
    }

    $(document).on('click','.btnSetSchedule',function () {
        var thiss = $(this);
        var appointmentid = thiss.closest('tr').attr('id')
        getSingle("appointments","appointment_id", appointmentid)
        current_appointment_id = appointmentid;
    })
</script>
@endsection