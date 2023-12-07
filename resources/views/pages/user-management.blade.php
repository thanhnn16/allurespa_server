@php use Carbon\Carbon; @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Quản lý khách hàng'])
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
            <div class="alert alert-white" role="alert">
                <strong>Khách có sinh nhật trong 15 ngày tới: </strong>
                <br>
                @foreach($users as $user)
                    @if($user->date_of_birth != null)
                        @php
                            $birthday = date('m-d', strtotime($user->date_of_birth));
                            $in15days = date('m-d', strtotime('+15 days'));
                        @endphp
                        @if($birthday <= $in15days)
                            <a href="#" class="user-details" data-bs-target="#user-information" data-bs-toggle="modal"
                               data-id="{{ $user->id }}">
                                <span class="text-primary">{{ $user->full_name }}</span>
                                <span
                                    class="text-primary">({{ Carbon::parse($user->date_of_birth)->format('d/m/Y') }})</span>
                                <br>
                            </a>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card mb-4 px-3">
            <div class="row">
                <div class="card-header pb-0">
                    <h6>Thêm khách hàng mới</h6>
                </div>
                <div class="d-flex justify-content-start align-self-auto py-1 px-2">
                    <button class="btn bg-gradient-secondary"><a href="/user-management-create" class="link-white">Thêm
                            khách hàng</a></button>
                    <div class="dropdown ps-2">
                        <button class="btn bg-gradient-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Nhập / xuất file
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="/users/template">Tải mẫu nhập</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#upload-excel">Nhập
                                    từ Excel</a></li>
                            <li><a class="dropdown-item" href="/users/export">Xuất ra Excel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Danh sách khách hàng</h6>
            </div>

            @if($users->isEmpty())
                <div class="alert">
                    <h4 class="text-center">Không có khách hàng nào</h4>
                </div>
            @else
                <div class="align-self-auto d-flex py-1 px-3 pb-3">
                    <div class="input-group">
                        <input type="text" id="search-customers" class="form-control"
                               placeholder="Tìm kiếm khách hàng theo tên / số điện thoại"
                               aria-label="Tìm kiếm khách hàng" aria-describedby="basic-addon2">
                        <span class="input-group-text"
                              id="basic-addon2"><i
                                class="fas fa-search"></i></span>
                    </div>
                </div>
                <button id="back-button" class="btn btn-secondary" style="display: none">Quay lại</button>

                <div class="form-group py-1 px-3 flex flex-row mt-3 justify-content-start align-items-center">
                    <label for="usersPerPage" class="form-label">Số khách hàng trên mỗi trang: </label>
                    <select id="numUsersPerPage" class="form-select w-30" name="numUsersPerPage"
                            onchange="location = this.value;">
                        <option value="?usersPerPage=10&page=1">10</option>
                        <option value="?usersPerPage=20&page=1">20</option>
                        <option value="?usersPerPage=50&page=1">50</option>
                    </select>
                </div>

                <div class="pagination-info">
                    Trang {{ $users->currentPage() }} trên tổng số {{ $users->lastPage() }} trang

                    <ul class="pagination my-2">
                        @if ($users->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @endif
                        @for($i = 1; $i <= $users->lastPage(); $i++)
                            @if($users->currentPage() == $i)
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($users->hasMorePages())
                            <li class="page-item">
                                <a class="page-link {{ $users->currentPage() == $users->lastPage() ? 'active' : '' }}"
                                   href="{{ $users->nextPageUrl() }}">></a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-disabled="true">></a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 min-height-600">
                        <table class="table align-items-center mb-0 mt-3">
                            <thead>
                            <tr>
                                <th class="align-middle text-center">
                                    <input type="checkbox" class="bg-gradient-faded-dark-vertical form-check-input"
                                           id="check-all">
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Họ tên
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Số
                                    điện thoại
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ngày sinh
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Giới tính
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ghi
                                    chú
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Hành động
                                </th>
                            </tr>
                            </thead>
                            <tbody id="customers-table">
                            @foreach($users as $user)
                                <tr>
                                    <td class="align-middle text-center">
                                        <input type="checkbox"
                                               class="user-checkbox bg-gradient-faded-dark form-check-input"
                                               id="check-{{ $user->id }}">
                                    </td>
                                    <td class="search-name">
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img
                                                    src="{{ $user->image == null ? "./img/logo.png" : $user->image }}"
                                                    class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->full_name == null ? 'N/A' : $user->full_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="search-phone">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->phone_number }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->date_of_birth != null ? $user->date_of_birth->format('d/m/Y') : 'N/A'}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->gender == 0 ? 'Nữ' : 'Nam'}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->note }}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="text-sm font-weight-bold mb-0 cursor-pointer"
                                               data-bs-toggle="modal"
                                               data-bs-target="#user-information"
                                               href="#" data-id="{{ $user->id }}">Xem
                                            </a>
                                            <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer"><a
                                                    href="{{ route('user-management.update', ['id' => $user->id]) }}"
                                                    data-id="{{ $user->id }}">Sửa</a></p>
                                            <a class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer user-delete"
                                               data-bs-toggle="modal" data-id="{{ $user->id }}"
                                               data-bs-target="#modal-notification">Xoá</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-start my-3 ms-2">
                            <button class="btn btn-danger" id="delete-selected" style="display:none;">Xoá đã chọn
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    </div>

    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
         aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Lưu ý</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="text-gradient text-danger mt-4">Bạn có chắc muốn xoá?</h4>
                        <p>Sau khi bạn xoá khách hàng này, bạn sẽ không thể hoàn tác việc xoá, có xác nhận xoá?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btn-delete">Xoá
                    </button>
                    <button type="button" class="btn btn-default ml-auto" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload-excel" tabindex="-1" role="dialog" aria-labelledby="upload-excel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn file cần nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/users/import" method="POST" enctype="multipart/form-data"
                      class="form-control bg-transparent">
                    <div class="modal-body">
                        @csrf
                        <input type="file" name="file" accept=".xlsx">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Nhập từ Excel</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static"
         data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-md-4">
                    <svg version="1.1" class="max-width-100" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 130.2 130.2">
                        <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10"
                                cx="65.1" cy="65.1" r="62.1"/>
                        <polyline class="path check" fill="none" stroke="#198754" stroke-width="6"
                                  stroke-linecap="round" stroke-miterlimit="10"
                                  points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                    </svg>
                    <h4 class="text-success mt-3">Thành công!</h4>
                    <p class="mt-3">Xoá khách hàng thành công.</p>
                    <button type="button" class="btn btn-sm mt-3 btn-gradient-dark" id="ok-button"
                            data-bs-dismiss="modal">
                        Quay lại
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="user-information">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ms-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="avatar">
                        <img src="" alt="image" id="user-image" class="avatar-img rounded-circle">
                    </div>
                    <p class="text-uppercase text-sm">THÔNG TIN CÁ NHÂN</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                <input class="form-control" disabled type="text" name="full_name"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email: </label>
                                <input class="form-control disabled" disabled type="email" name="email"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Số điện thoại: </label>
                                <input class="form-control disabled" disabled type="tel" name="phone_number"
                                       value="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                <input class="form-control" disabled type="text" name="address"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                <input class="form-control" disabled type="text" name="date_of_birth"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Ghi chú</label>
                                <input class="form-control" disabled type="text" name="note"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Tình trạng da</label>
                                <textarea class="form-control" type="text" name="note" disabled
                                ></textarea>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">LỊCH SỬ ĐẶT LỊCH</p>
                        <div id="appointment-history">
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">LỊCH SỬ DỊCH VỤ</p>
                        <div id="service-history"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let sessionError = sessionStorage.getItem('error');
            if (sessionError) {
                $('#alert').html('<div class="alert alert-danger" role="alert"><p class="text-white text-lg text-bold mb-0">' + sessionError + '</p></div>');
                sessionStorage.removeItem('error');
            }
            $('#check-all').change(function () {
                if ($(this).is(':checked')) {
                    $('input[type=checkbox]').prop('checked', true);
                    $('#delete-selected').show();
                } else {
                    $('input[type=checkbox]').prop('checked', false);
                    $('#delete-selected').hide();
                }
            });

            $('input[type=checkbox]').change(function () {
                if ($('input[type=checkbox]:checked').length === $('input[type=checkbox]').length) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }

                if ($('input[type=checkbox]:checked').length > 0) {
                    $('#delete-selected').show();
                } else {
                    $('#delete-selected').hide();
                    $('#check-all').prop('checked', false);
                }
            });


            $('#search-customers').keypress(function (event) {
                if (event.which == 13) {
                    let value = $(this).val().toLowerCase();
                    window.location.href = '?search=' + value;
                }
            });

            $('#upload-excel').on('shown.bs.modal', function () {
                if ($('input[type=file]').val() === "") {
                    $('.btn-success').attr('disabled', true);
                }
            });
            $('input[type=file]').change(function () {
                if ($('input[type=file]').val() !== "") {
                    $('.btn-success').attr('disabled', false);
                }
            });

            $('.btn-success').click(function () {
                $('#upload-excel').modal('hide');
            });

            $('#modal-notification').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                $('#btn-delete').off('click').on('click', function (e) {
                    e.preventDefault();
                    $('#modal-notification').modal('hide');
                    $.ajax({
                        url: 'user-management/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);
                            if (response.error) {
                                console.log(response.error);
                            } else {
                                $('#statusSuccessModal').modal('show');
                                $('#ok-button').click(function () {
                                    $('#statusSuccessModal').modal('hide');
                                    location.reload();
                                });
                            }
                        },
                    })
                });
            });

            $('#user-information').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                console.log(id)
                $.ajax({
                    url: 'user-management/' + id,
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        if (response.error) {
                            sessionStorage.setItem('error', response.error);
                        } else {
                            let img = response.user.image == null ? "./img/logo.png" : response.user.image;
                            let dob = response.user.date_of_birth == null ? 'N/A' : response.user.date_of_birth;
                            dob = new Date(dob);
                            dob = dob.toLocaleDateString('vi-VN');
                            $('#user-image').attr('src', img);
                            $('input[name=full_name]').val(response.user.full_name);
                            $('input[name=email]').val(response.user.email);
                            $('input[name=phone_number]').val(response.user.phone_number);
                            $('input[name=address]').val(response.user.address);
                            $('input[name=date_of_birth]').val(dob);
                            $('input[name=note]').val(response.user.note);
                            $('#appointment-history').html('');
                            $('#service-history').html('');

                            if (response.appointments.length > 0) {
                                let appointmentHistory = '<table class="table align-items-center mb-0 mt-3">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thời gian</th>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dịch vụ</th>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tư vấn</th>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>';
                                $.each(response.appointments, function (index, value) {
                                    let status = value.status === 'pending' ? 'Chờ xác nhận' : value.status === 'scheduled' ? 'Đã xác nhận' : value.status === 'completed' ? 'Đã hoàn thành' : 'Đã hủy';
                                    let isConsultation = value.is_consultation === 1 ? 'Có' : 'Không';
                                    let startDate = new Date((value.start_date)).toLocaleTimeString('vi-VN') + ' ' + new Date(value.start_date).toLocaleDateString('vi-VN');
                                    let endDate = new Date(value.end_date).toLocaleTimeString('vi-VN') + ' ' + new Date(value.end_date).toLocaleDateString('vi-VN');
                                    let treatmentName = value.treatment_name == null ? 'N/A' : value.treatment_name;
                                    appointmentHistory += '<tr>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + startDate + " - " + endDate + '</p>' +
                                    '</td>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + treatmentName + '</p>' +
                                    '</td>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + isConsultation + '</p>' +
                                    '</td>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + status + '</p>' +
                                        '</td>' +
                                        '</tr>';
                                });
                                appointmentHistory += '</tbody></table>';
                                $('#appointment-history').html(appointmentHistory);
                            } else {
                                $('#appointment-history').html('<p class="text-center">Không có lịch hẹn nào</p>');
                            }

                            if (response.invoices.length > 0) {
                                let serviceHistory = '<table class="table align-items-center mb-0 mt-3">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thời gian</th>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ghi chú</th>' +
                                    '<th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>';
                                $.each(response.invoices, function (index, value) {
                                    let status = value.status === 'pending' ? 'Chờ xác nhận' : value.status === 'scheduled' ? 'Đã xác nhận' : value.status === 'completed' ? 'Đã hoàn thành' : 'Đã hủy';
                                    let createdDate = new Date(value.created_at).toLocaleDateString('vi-VN');
                                    serviceHistory += '<tr>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + createdDate + '</p>' +
                                    '</td>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + value.note + '</p>' +
                                    '</td>' +
                                    '<td class="align-middle text-center text-sm">' +
                                    '<p class="text-sm font-weight-bold mb-0">' + status + '</p>' +
                                        '</td>' +
                                        '</tr>';
                                });
                                serviceHistory += '</tbody></table>';
                                $('#service-history').html(serviceHistory);
                            } else {
                                $('#service-history').html('<p class="text-center">Không có dịch vụ nào</p>');
                            }

                        }
                    },
                })
            });

            $('#delete-selected').click(function () {
                let selectedIds = [];
                $('.user-checkbox:checked').each(function () {
                    let id = $(this).attr('id').replace('check-', '');
                    selectedIds.push(id);
                    console.log(selectedIds)
                });

                if (selectedIds.length > 0) {
                    let confirmDelete = confirm('Bạn có chắc muốn xoá những khách hàng đã chọn?\nThao tác này không thể hoàn tác.');
                    if (!confirmDelete) {
                        return;
                    }
                    $.ajax({
                        url: '/user-management/delete-selected',
                        type: 'POST',
                        data: {
                            selectedIds: selectedIds,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.error) {
                                sessionStorage.setItem('error', response.error);
                                location.reload();
                            } else {
                                $('#statusSuccessModal').modal('show');
                                location.reload();
                            }
                        },
                    });
                }
            });

            let urlParams = new URLSearchParams(window.location.search);
            let usersPerPage = urlParams.get('usersPerPage');
            let search = urlParams.get('search');
            if (usersPerPage) {
                $('#numUsersPerPage').val('?usersPerPage=' + usersPerPage + '&page={{ $users->currentPage() }}');
            } else {
                $('#numUsersPerPage').val('?usersPerPage=10&page={{ $users->currentPage() }}');
            }
            if (search) {
                $('#search-customers').val(search);
                if (search) {
                    $('#back-button').attr('style', 'display: block').click(function () {
                        window.location.href = '/user-management';
                    });
                }
            }


            $('.edit-user-link').click(function (e) {
                e.preventDefault();
                const id = $(this).data('id');

            });


        });

    </script>
@endsection

