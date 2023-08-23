<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>


    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
</head>


<body>

    <div class="container">


        <div class='container'>
            <ul class="ml-auto">
                <button data-bs-toggle="modal" data-bs-target="#newEvent" class="btn-info">+ Подія</button>
                <button data-bs-toggle="modal" data-bs-target="#newReminder" class="btn-primary"> + Нагадування</button>
                <div class="modal" id="newReminder" tabindex="-1" aria-labelledby="newReminderLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newReminderLabel">Додайте Нагадування</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('reminders.create') }}" enctype="application/x-www-form-urlencoded">
                                    @csrf
                                    <label for="rem_title">Введіть назву нагадування:</label>
                                    <input type="text" id="rem_title" name="rem_title">
                                    <br>
                                    <br>
                                    <label for="rem_color">Виберіть колір:</label>
                                    <input type="color" id="rem_color" name="rem_color">
                                    <br>
                                    <br>
                                    <label for="rem_datetime">Дата та час початку</label>
                                    <input type="datetime-local" id="rem_datetime" name="rem_datetime">
                                    @if(auth()->check())
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    @endif
                                    <br>
                                    <button type="submit" class="btn btn-primary">Готово</button>
                                    
                            </div>

                        </div>
                        </form>


            </ul>
            <div id="calendar"></div>
        </div>

    </div>





    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: '/full-calender',
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    var color = prompt('Event Color (e.g. red, blue, green):');

                    if (title && color) {
                        var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                        var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                        $.ajax({
                            url: "/full-calender/action",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                color: color, // Додайте параметр кольору
                                type: 'add'
                            },
                            success: function(data) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Created Successfully");
                            }
                        })
                    }
                },

                editable: true,
                eventResize: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },

                eventClick: function(event) {
                    if (confirm("Are you sure you want to remove it?")) {
                        var id = event.id;
                        $.ajax({
                            url: "/full-calender/action",
                            type: "POST",
                            data: {
                                id: id,
                                type: "delete"
                            },
                            success: function(response) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Deleted Successfully");
                            }
                        })
                    }
                },
                
                eventRender: function(event, element) {
                    element.contextmenu(function() {
                        var newTitle = prompt('Edit Event Title:', event.title);
                        var newColor = prompt('Edit Event Color:', event.title);
                        if (newTitle && newColor !== null) {
                            event.title = newTitle;
                            event.title = newColor;
                            $.ajax({
                                url: "/full-calender/update-event",
                                type: "POST",
                                data: {
                                    id: event.id,
                                    title: newTitle,
                                    color: newColor,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Updated Successfully");
                                }
                            });
                        }
                    });
                }
            });

        });
    </script>
    @endsection
</body>

</html>