@extends('layouts.app', [
    'class' => 'g-sidenav-show bg-gray-100',
    ]
)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
<style>
    body {
        overflow-x: hidden !important;
    }
</style>

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
    <div id="colorNote">
        <div class="card mb-4 col-11 align-items-center m-auto py-4">
            <div class="row w-100 d-flex align-items-center justify-content-center">
                <div class="col-12 d-flex justify-content-around">
                    <div class="col-2">
                        <div class="pending-color d-block h-50 w-50" style="background-color: #fa8d00;"></div>
                        <p class="text-uppercase text-sm">Đang chờ</p>
                    </div>
                    <div class="col-2">
                        <div class="scheduled-color d-block h-50 w-50" style="background-color: #c57fec;"></div>
                        <p class="text-uppercase text-sm">Đã hẹn</p>
                    </div>
                    <div class="col-2">
                        <div class="completed-color d-block h-50 w-50" style="background-color: #28a745;"></div>
                        <p class="text-uppercase text-sm">Đã hoàn thành</p>
                    </div>
                    <div class="col-2">
                        <div class="canceled-color d-block h-50 w-50" style="background-color: #dc3545;"></div>
                        <p class="text-uppercase text-sm">Đã hủy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-auto">
        <div class="card mb-4 col-11 py-4 px-1 m-auto">
            <div id="full_calendar_events" class="m-auto w-95"></div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="appointment-information">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ms-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin lịch hẹn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-uppercase text-sm">THÔNG TIN CHI TIẾT</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Họ và tên khách hàng
                                    <input class="form-control" disabled type="text" name="full_name"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label">Email
                                    <input class="form-control disabled" id="email" autocomplete="email" disabled
                                           type="email" name="email"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number" class="form-control-label">Số điện thoại
                                    <input class="form-control disabled" id="phone_number" disabled type="tel"
                                           name="phone_number"
                                           value=""></label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Tên liệu trình
                                    <input class="form-control" disabled type="text" name="treatment_name"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_date" class="form-control-label">Thời gian
                                    <input class="form-control" disabled type="text" name="appointment_date"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="treatment_price" class="form-control-label">Giá
                                    <input class="form-control" disabled type="text" name="treatment_price"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="form-control-label">Ghi chú
                                    <textarea class="form-control" type="text" name="note" disabled
                                    ></textarea></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="form-control-label">Trạng thái
                                    <select class="form-control" name="status" disabled
                                    >
                                        <option value="pending">Đang chờ</option>
                                        <option value="scheduled">Đã hẹn</option>
                                        <option value="completed">Đã hoàn thành</option>
                                        <option value="canceled">Đã hủy</option>
                                    </select></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="edit-button">Sửa</button>
                    <button type="button" class="btn btn-danger" id="delete-button" style="display:none;">Xoá
                    </button>
                    <button type="button" class="btn btn-success" id="save-button" style="display:none;">Lưu
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/vi.js'></script>
    {{--    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>--}}

    <script>
        const appointmentsData = {!! json_encode($appointments) !!};
        let events = [];
        appointmentsData.forEach(function (appointment) {
            console.log(appointment)
            events.push({
                title: appointment.full_name,
                start: appointment.appointment_date,
                color: appointment.status === 'completed' ? '#28a745' :
                    appointment.status === 'pending' ? '#fa8d00' :
                        appointment.status === 'scheduled' ? '#c57fec' :
                            '#dc3545',
                completed: appointment.status === 'completed',
                comment: appointment.note,

            });
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
                displayEventEnd: true,
                firstDay: 1,
                defaultView: 'agendaWeek',
                locale: 'vi',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaDay,agendaWeek,month,listWeek'
                },
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
                        }
                    });
                },
                eventClick: function (event) {
                    console.log(event)
                    let evId = event._id.at(-1);
                    console.log(evId)
                    $.ajax({
                        url: '/appointment-management/' + evId,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            let appointment = response.appointment;
                            let time = appointment.appointment_date.split(' ');
                            time[0] = time[0].split('-').reverse().join('/');
                            let appointment_date = time[1] + ', ngày ' + time[0];
                            let price = String(appointment.price).replace(/(.)(?=(\d{3})+$)/g, '$1,') + ' VNĐ';
                            console.log(appointment);
                            $('#appointment-information').modal('show');
                            $('#appointment-information input[name="full_name"]').val(appointment.full_name);
                            $('#appointment-information input[name="email"]').val(appointment.email);
                            $('#appointment-information input[name="phone_number"]').val(appointment.phone_number);
                            $('#appointment-information input[name="treatment_name"]').val(appointment.treatment_name);
                            $('#appointment-information input[name="appointment_date"]').val(appointment_date);
                            $('#appointment-information input[name="treatment_price"]').val(price);
                            $('#appointment-information textarea[name="note"]').val(appointment.note);
                            $('#appointment-information select[name="status"]').val(appointment.status);

                            $('#edit-button').click(function () {
                                $('#appointment-information input[name="appointment_date"]').attr('type', 'datetime-local');
                                $('#appointment-information input[name="appointment_date"]').removeAttr('disabled');
                                $('#appointment-information textarea[name="note"]').removeAttr('disabled');
                                $('#appointment-information select[name="status"]').removeAttr('disabled');
                                $('#edit-button').hide();
                                $('#save-button').show();
                                $('#delete-button').show();
                            });
                        },
                    });
                }
            });
        });

    </script>
@endsection

