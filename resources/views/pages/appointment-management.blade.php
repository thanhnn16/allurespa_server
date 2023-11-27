@extends('layouts.app', [
    'class' => 'g-sidenav-show bg-gray-100',
    ]
)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Quản lý lịch hẹn'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div id="alert">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <p class="text-white mb-0">
                            {{ session('error') }}</p>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <p class="text-white mb-0">
                            {{ session('success') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row d-flex ">
        <div class="card mb-4 col-11 align-items-center m-auto py-4 px-2">
            <div id='full_calendar_events'></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/vi.js'></script>
    <script>
        const appointmentsData = {!! json_encode($appointments) !!};
        let events = [];
        appointmentsData.forEach(function(appointment) {
            console.log(appointment)
            events.push({
                title: appointment.full_name,
                start: appointment.appointment_date,
                color: appointment.status === 'completed' ? '#28a745' : '#dc3545',
                completed: appointment.status === 'completed' ? true : false,
                comment: appointment.note,
            });
            console.log(events)
        });
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            let calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                events: events,
                timezone: 'Asia/Ho_Chi_Minh',
                displayEventTime: true,
                firstDay: 1,
                locale: 'vi',
                definedTheme: 'bootstrap5',
                eventRender: function (event) {
                    event.allDay = event.allDay === 'true';
                },
                selectable: true,
                selectHelper: true,
                select: function (event_start, allDay) {
                    const event_name = prompt('Lịch mới:');
                    if (event_name) {
                        const event_start = $.fullCalendar.formatDate(event_start, "DD-MM-Y HH:mm:ss");
                        $.ajax({
                            url: "/appointments",
                            data: {
                                event_name: event_name,
                                event_start: event_start,
                                type: 'create'
                            },
                            type: "POST",
                            success: function (data) {
                                displayMessage("Event created.");
                                calendar.fullCalendar('renderEvent', {
                                    id: data.id,
                                    title: event_name,
                                    start: event_start,
                                    end: event_end,
                                    allDay: allDay
                                }, true);
                                calendar.fullCalendar('unselect');
                            }
                        });
                    }
                },
                eventDrop: function (event, delta) {
                    const event_start = $.fullCalendar.formatDate(event.start, "DD-MM-Y");
                    $.ajax({
                        url: '/appointment-management',
                        data: {
                            title: event.event_name,
                            start: event_start,
                            id: event.id,
                            type: 'edit'
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("Event updated");
                        }
                    });
                },
                eventClick: function (event) {
                    const eventDelete = confirm("Are you sure?");
                    if (eventDelete) {
                        $.ajax({
                            type: "POST",
                            url: '/appointment-management',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event removed");
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
@endsection

