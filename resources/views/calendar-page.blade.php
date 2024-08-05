
@extends('layouts.main')

@section('title','Calendar')

@section('content')

<div class="card mt-5" style="background-color:">
    
    <div id='calendar' style=""></div>
    
</div>

@endsection


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
 $(function() {
       
        var SITEURL = "{{ url('/') }}";
        var bookingHoliday  = @json($events);
        var calendar = $('#calendar').fullCalendar({
           
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            //events: SITEURL + "/calendar",
            events:bookingHoliday,

            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                        event.allDay = true;
                } else {
                        event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,

            select: function (start, end, allDay) { 
                var title = prompt('Holiday Title:');
                console.log(title);
                
                if (title) {
                    var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    //console.log(start,end);

                    $.ajax({
                        url: 'createvent',
                        data: 'holiday_name=' + title + '&date_of_holiday=' + start + '&end=' + end +'&_token=' +"{{ csrf_token() }}",
                        type: "post",
                        success: function (data) {
                            displayMessage("Event Created Successfully");
                        }
                    });

                    calendar.fullCalendar('renderEvent',{title: title,start: start,end: end,allDay: allDay},true);

                }
                calendar.fullCalendar('unselect');
            },

            eventClick: function (event) {
                console.log(event.id);
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "deleteholiday",
                    data: "&id=" + event.id+'&_token=' +"{{ csrf_token() }}",
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Event Created Successfully");
                        }
                    }
                });
            }
        }

        });

       
 });

 function displayMessage(message) {
        toastr.success(message, 'Event');
 } 
</script>
