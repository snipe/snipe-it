<link rel='stylesheet' href="{{ url('css/fullcalendar.min.css')}}" />

<h3>Calendar</h3>

<div id='calendar'></div>

<script src="{{ url('js/jquery.js')}}"></script>
<script src="{{ url('js/moment.min.js')}}"></script>
<script src="{{ url('js/fullcalendar.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events : [
                @foreach($tasks as $task)
                {
                    title : '{{ $task->name }}',
                    start : '{{ $task->task_date }}',
                    end : '{{ $task->task_end_date }}'
                },
                @endforeach
            ]
        })
    });
</script>
