@extends('layouts.app', [
    'class' => 'g-sidenav-show bg-gray-100',
    ]
)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>

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
                                <label for="edt-full_name" class="form-control-label w-100">Họ và tên khách hàng
                                    <input class="form-control" id="edt-full_name" disabled type="text"
                                           name="full_name"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edt-email" class="form-control-label w-100">Email
                                    <input class="form-control disabled" id="edt-email" autocomplete="email"
                                           disabled
                                           type="email" name="email"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edt-phone_number" class="form-control-label w-100">Số điện thoại
                                    <input class="form-control disabled" id="edt-phone_number" disabled type="tel"
                                           name="phone_number"
                                           value=""></label>
                            </div>
                        </div>
                        <p class="text-uppercase text-sm">Đặt lịch để</p>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" disabled type="radio" name="edt-muc_dich"
                                       id="edt-tu-van">
                                <label class="form-check-label" for="edt-tu-van">
                                    Tư vấn
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" disabled type="radio" name="edt-muc_dich"
                                       id="edt-for_treatment"
                                       checked>
                                <label class="form-check-label" for="edt-for_treatment">
                                    Làm liệu trình
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edt-treatment_name" class="form-control-label w-100">Tên liệu trình
                                    <input class="form-control" disabled type="text" id="edt-treatment_name"
                                           name="treatment_name"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="edt-start_date" class="form-control-label w-100">Bắt đầu
                                    <input class="form-control" id="edt-start_date" type="datetime-local"
                                           name="edt-start_date" disabled
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="edt-end_date" class="form-control-label w-100">Kết thúc
                                    <input class="form-control" id="edt-end_date" type="datetime-local"
                                           name="edt-end_date" disabled
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="edt-treatment_price" class="form-control-label w-100">Giá tạm tính
                                    <input class="form-control" id="edt-treatment_price" disabled type="text"
                                           name="edt-treatment_price"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edt-note" class="form-control-label w-100">Ghi chú
                                    <textarea class="form-control" id="edt-note" type="text" name="note" disabled
                                    ></textarea></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edt-status" class="form-control-label w-100">Trạng thái
                                    <select class="form-control" id="edt-status" name="status" disabled
                                    >
                                        <option value="pending">Đang chờ</option>
                                        <option value="scheduled">Đã hẹn</option>
                                        <option value="completed">Đã hoàn thành</option>
                                        <option value="cancelled">Đã hủy</option>
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
    <div class="modal fade" tabindex="-1" id="appointment-create">
        <div class="modal-dialog modal-dialog-scrollable modal-lg ms-auto">
            <div class="modal-content ms-auto">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin lịch hẹn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-uppercase text-sm">THÔNG TIN CHI TIẾT</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label for="full_name" class="form-control-label w-100">Tìm khách hàng
                                    <input class="form-control" id="full_name" type="text" name="full_name"
                                           value="">
                                </label>
                                <ul class="list-group list-group-flush position-absolute left-0 bottom--2"
                                    id="full_name_list"
                                    style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label w-100">Email
                                    <input class="form-control disabled" id="email" autocomplete="email" disabled
                                           type="email" name="email"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number" class="form-control-label w-100">Số điện thoại
                                    <input class="form-control disabled" id="phone_number" disabled type="tel"
                                           name="phone_number"
                                           value=""></label>
                            </div>
                        </div>
                        <p class="text-uppercase text-sm">Đặt lịch để</p>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="muc_dich" id="tu-van">
                                <label class="form-check-label" for="tu-van">
                                    Tư vấn
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="muc_dich" id="for_treatment"
                                       checked>
                                <label class="form-check-label" for="for_treatment">
                                    Làm liệu trình
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="treatment_name" class="form-control-label w-100">Chọn liệu trình
                                    <input class="form-control" id="treatment_name" type="text"
                                           name="treatment_name"
                                           value="">
                                </label>
                                <ul class="list-group list-group-flush" id="treatment_name_list"
                                    style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="start_date" class="form-control-label w-100">Bắt đầu
                                    <input class="form-control" id="start_date" type="datetime-local"
                                           name="start_date"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="end_date" class="form-control-label w-100">Kết thúc
                                    <input class="form-control" id="end_date" type="datetime-local"
                                           name="end_date"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="treatment_price" class="form-control-label w-100">Giá tạm tính
                                    <input class="form-control" id="treatment_price" disabled type="text"
                                           name="treatment_price"
                                           value=""></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="form-control-label w-100">Ghi chú
                                    <textarea class="form-control" id="note" type="text" name="note"
                                    ></textarea></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="form-control-label w-100">Trạng thái
                                    <select class="form-control" name="status"
                                    >
                                        <option value="pending">Chờ xác nhận</option>
                                        <option value="scheduled">Đã hẹn</option>
                                        <option value="completed">Đã hoàn thành</option>
                                        <option value="cancelled">Đã hủy</option>
                                    </select></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="reset-button" class="btn btn-danger">Reset
                    </button>
                    <button type="button" class="btn btn-success" id="create-button">Thêm
                    </button>
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
        console.log(appointmentsData)
        let events = [];
        appointmentsData.forEach(function (appointment) {
            events.push({
                id: appointment.id,
                title: appointment.full_name === null ? 'N/A' : appointment.full_name,
                start: appointment.start_date,
                end: appointment.end_date,
                is_consultation: appointment.is_consultation,
                color: appointment.status === 'completed' ? '#28a745' :
                    appointment.status === 'pending' ? '#fa8d00' :
                        appointment.status === 'scheduled' ? '#c57fec' :
                            '#dc3545',
                completed: appointment.status === 'completed',
                comment: appointment.note,

            });
        });
        console.log(events);
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            let calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                events: events,
                displayEventTime: true,
                displayEventEnd: true,
                firstDay: 1,
                defaultView: 'agendaWeek',
                locale: 'vi',
                minTime: '08:00:00',
                maxTime: '20:00:00',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaDay,agendaWeek,month,listWeek'
                },
                eventRender: function (event, element) {
                    event.allDay = event.allDay === 'true';
                    element.find('.fc-title').append("<br/>" + event.comment);
                    element.attr('title', event.is_consultation === 1 ? 'Tư vấn' : 'Liệu trình');

                },
                selectable: true,
                selectHelper: true,
                select: function (event_start, event_end, allDay) {
                    let userId = '';
                    let treatmentId = '';
                    let isConsultation = false;
                    let isValidUser = false;
                    let isValidTreatment = false;
                    $('#appointment-create').modal('show');
                    $('#appointment-create input[name="start_date"]').val((event_start).format('YYYY-MM-DD HH:mm'));
                    $('#appointment-create input[name="end_date"]').val((event_end).format('YYYY-MM-DD HH:mm')).on(
                        'change', function () {
                            let start_date = $('#appointment-create input[name="start_date"]').val();
                            let end_date = $('#appointment-create input[name="end_date"]').val();
                            if (end_date < start_date) {
                                alert('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                                return false;
                            } else if (!end_date) {
                                alert('Vui lòng chọn thời gian kết thúc');
                                return false;
                            }
                        });

                    $('#full_name').on(
                        'keyup', function () {
                            let full_name = $('#appointment-create input[name="full_name"]').val();
                            if (full_name.length > 0) {
                                $.ajax({
                                    url: '/user-management-search',
                                    data: {
                                        q: full_name,
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    },
                                    type: "get",
                                    success: function (response) {
                                        let html = '';

                                        if (response.error) {
                                            html += '<li class="list-group-item cursor-pointer list-group-item-danger w-100">' + response.error + '</li>';
                                            $('#full_name_list').html(html);
                                            $('#full_name_list').show();
                                            return;
                                        }

                                        let customers = response.users;
                                        customers.forEach(function (customer) {
                                            html += '<li class="list-group-item cursor-pointer list-group-item-action w-100" data-id=" ' + customer.id + ' " data-email="' + customer.email + '" data-phone_number="' + customer.phone_number + '">' + customer.full_name + ' - ' + customer.phone_number + '</li>';
                                        });
                                        $('#full_name_list').html(html);
                                        $('#full_name_list').show();
                                        $('#full_name_list li').click(function () {
                                            $('#appointment-create input[name="full_name"]').val($(this).text());
                                            $('#appointment-create input[name="email"]').val($(this).data('email'));
                                            $('#appointment-create input[name="phone_number"]').val($(this).data('phone_number'));
                                            userId = $(this).data('id');
                                            isValidUser = true;
                                            $('#full_name_list').hide();
                                        });
                                    }
                                });
                            } else {
                                $('#full_name_list').hide();
                            }
                        });

                    $('#appointment-create input[name="muc_dich"]').on('change', function () {
                        if ($(this).attr('id') === 'tu-van') {
                            $('#appointment-create input[name="treatment_name"]').attr('disabled', true).val('');
                            $('#appointment-create input[name="treatment_price"]').val('');
                            isConsultation = true;
                            isValidTreatment = true;
                        } else {
                            $('#appointment-create input[name="treatment_name"]').removeAttr('disabled');
                            isConsultation = false;
                            isValidTreatment = false;
                        }
                    });

                    $('#treatment_name').on(
                        'keyup', function () {
                            let treatment_name = $('#appointment-create input[name="treatment_name"]').val();
                            if (treatment_name.length > 0) {
                                $.ajax({
                                    url: '/treatment-management-search',
                                    data: {
                                        q: treatment_name,
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    },
                                    type: "get",
                                    success: function (response) {
                                        let html = '';

                                        if (response.error) {
                                            html += '<li class="list-group-item cursor-pointer list-group-item-danger w-100">' + response.error + '</li>';
                                            $('#treatment_name_list').html(html);
                                            $('#treatment_name_list').show();
                                            return;
                                        }

                                        let treatments = response.treatments;
                                        treatments.forEach(function (treatment) {
                                            html += '<li class="list-group-item cursor-pointer list-group-item-action w-100" data-id=" ' + treatment.id + '" data-price="' + treatment.price + '">' + treatment.treatment_name + '</li>';
                                        });
                                        $('#treatment_name_list').html(html);
                                        $('#treatment_name_list').show();
                                        $('#treatment_name_list li').click(function () {
                                            $('#appointment-create input[name="treatment_name"]').val($(this).text());
                                            $('#appointment-create input[name="treatment_price"]').val($(this).data('price'));
                                            treatmentId = $(this).data('id');
                                            isValidTreatment = true;
                                            $('#treatment_name_list').hide();
                                        });
                                    }
                                });
                            } else {
                                $('#treatment_name_list').hide();
                            }
                        });

                    $('#reset-button').click(function () {
                        $('#appointment-create input[name="full_name"]').val('');
                        $('#appointment-create input[name="email"]').val('');
                        $('#appointment-create input[name="phone_number"]').val('');
                        $('#appointment-create input[name="treatment_name"]').val('');
                        $('#appointment-create input[name="treatment_price"]').val('');
                        $('#appointment-create input[name="start_date"]').val('');
                        $('#appointment-create input[name="end_date"]').val('');
                        $('#appointment-create textarea[name="note"]').val('');
                        $('#appointment-create select[name="status"]').val('pending');
                    });

                    $('#create-button').click(function () {
                        let full_name = $('#appointment-create input[name="full_name"]').val();
                        let phone_number = $('#appointment-create input[name="phone_number"]').val();
                        let start_date = moment($('#appointment-create input[name="start_date"]').val()).format('YYYY-MM-DD HH:mm');
                        let end_date = moment($('#appointment-create input[name="end_date"]').val()).format('YYYY-MM-DD HH:mm');
                        let note = $('#appointment-create textarea[name="note"]').val();
                        let status = $('#appointment-create select[name="status"]').val();
                        console.log(start_date, end_date);
                        if (!full_name) {
                            alert('Vui lòng nhập họ và tên');
                            return false;
                        } else if (!isValidUser) {
                            alert('Vui lòng chọn khách hàng');
                            return false;
                        } else if (!isValidTreatment) {
                            alert('Vui lòng chọn liệu trình');
                            return false;
                        } else if (!phone_number) {
                            alert('Vui lòng nhập số điện thoại');
                            return false;
                        } else if (!start_date) {
                            alert('Vui lòng nhập thời gian bắt đầu');
                            return false;
                        } else if (!end_date) {
                            alert('Vui lòng nhập thời gian kết thúc');
                            return false;
                        } else if (end_date < start_date) {
                            alert('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                            return false;
                        }
                        $.ajax({
                            url: '/appointment-management',
                            data: {
                                user_id: userId,
                                treatment_id: treatmentId,
                                start_date: start_date,
                                end_date: end_date,
                                is_consultation: isConsultation ? "1" : "0",
                                is_all_day: !allDay.data ? "0" : "1",
                                note: note,
                                status: status,
                                type: 'create'
                            },
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.error) {
                                    alert(response.error);
                                    return;
                                }
                                $('#appointment-create').modal('hide');
                                $('#reset-button').click();
                                // location.reload();
                            }
                        });
                    });
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
                    $.ajax({
                        url: '/appointment-management/' + event.id,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            let appointment = response.appointment;
                            let start_date = new Date(appointment.start_date).toISOString().slice(0, 16);
                            let end_date = new Date(appointment.end_date).toISOString().slice(0, 16);

                            let price = appointment.price === null ? '0' : String(appointment.price).replace(/(.)(?=(\d{3})+$)/g, '$1,') + ' VNĐ';
                            $('#appointment-information').modal('show');
                            $('#edt-full_name').val(appointment.full_name === null ? 'N/A' : appointment.full_name);
                            $('#edt-email').val(appointment.email === null ? 'N/A' : appointment.email);
                            $('#edt-phone_number').val(appointment.phone_number);
                            $('#edt-treatment_name').val(appointment.treatment_name);
                            $('#edt-start_date').val(start_date);
                            $('#edt-end_date').val(end_date);
                            $('#edt-treatment_price').val(price);
                            $('#edt-tu-van').prop('checked', appointment.is_consultation === 1);
                            $('#edt-for_treatment').prop('checked', appointment.is_consultation === 0);
                            $('#edt-note').val(appointment.note);
                            $('#edt-status').val(appointment.status);

                            $('#edit-button').click(function () {
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
        })
        ;

    </script>
@endsection

