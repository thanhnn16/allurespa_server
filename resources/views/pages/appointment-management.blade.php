@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Quản lý mỹ phẩm'])
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
        <div class="card mb-4 px-3">
            <div class="row">
                <div class="card-header pb-0">
                    <h6>Thêm mỹ phẩm mới</h6>
                </div>
                <div class="d-flex justify-content-start align-self-auto py-1 px-2">
                    <button class="btn bg-gradient-secondary"><a href="/user-management-create" class="link-white">Thêm
                            mỹ phẩm</a></button>
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
                <h6>Danh sách mỹ phẩm</h6>
            </div>

            @if($cosmetics->isEmpty())
                <div class="alert">
                    <h4 class="text-center">Không có mỹ phẩm nào</h4>
                </div>
            @else
                <div class="align-self-auto d-flex py-1 px-3 pb-3">
                    <div class="input-group">
                        <input type="text" id="search-customers" class="form-control"
                               placeholder="Tìm kiếm mỹ phẩm theo tên"
                               aria-label="Tìm kiếm mỹ phẩm" aria-describedby="basic-addon2">
                        <span class="input-group-text"
                              id="basic-addon2"><i
                                class="fas fa-search"></i></span>
                    </div>
                </div>
                <button id="back-button" class="btn btn-secondary" style="display: none">Quay lại</button>

                <div class="form-group py-1 px-3 flex flex-row mt-3 justify-content-start align-items-center">
                    <label for="cosmeticsPerPage" class="form-label">Số mỹ phẩm trên mỗi trang: </label>
                    <select id="cosmeticsPerPage" class="form-select w-30" name="cosmeticsPerPage"
                            onchange="location = this.value;">
                        <option value="?cosmeticsPerPage=10&page=1">10</option>
                        <option value="?cosmeticsPerPage=20&page=1">20</option>
                        <option value="?cosmeticsPerPage=50&page=1">50</option>
                    </select>
                </div>

                <div class="pagination-info">
                    Trang {{ $cosmetics->currentPage() }} trên tổng số {{ $cosmetics->lastPage() }} trang

                    <ul class="pagination my-2">
                        @if ($cosmetics->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="{{ $cosmetics->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $cosmetics->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @endif
                        @for($i = 1; $i <= $cosmetics->lastPage(); $i++)
                            @if($cosmetics->currentPage() == $i)
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="{{ $cosmetics->url($i) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li class="page-item"><a class="page-link"
                                                         href="{{ $cosmetics->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($cosmetics->hasMorePages())
                            <li class="page-item">
                                <a class="page-link {{ $cosmetics->currentPage() == $cosmetics->lastPage() ? 'active' : '' }}"
                                   href="{{ $cosmetics->nextPageUrl() }}">></a>
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
                                    Tên mỹ phẩm
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Loại mỹ phẩm
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Mô tả
                                </th>
                                <th class="text-uppercase text-center max-width-200 text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Giá
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Hành động
                                </th>
                            </tr>
                            </thead>
                            <tbody id="customers-table">
                            @foreach($cosmetics as $cosmetic)
                                <tr>
                                    <td class="align-middle text-center">
                                        <input type="checkbox"
                                               class="user-checkbox bg-gradient-faded-dark form-check-input"
                                               id="check-{{ $cosmetic->id }}">
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img
                                                    src="{{ $cosmetic->image == null ? "./img/logo.png" : $cosmetic->image }}"
                                                    class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cosmetic->cosmetic_name == null ? 'N/A' : $cosmetic->treatment_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $cosmetic->cosmetic_category_name }}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm max-width-200">
                                        <p class="text-sm font-weight-bold mb-0 overflow-hidden whitespace-nowrap" style="text-overflow: ellipsis!important;">{{ $cosmetic->description != null ? $cosmetic->description : 'N/A'}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ number_format($cosmetic->price, 0, ',', '.') }} VNĐ</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="text-sm font-weight-bold mb-0 cursor-pointer"
                                               data-bs-toggle="modal"
                                               data-bs-target="#user-information"
                                               href="#" data-id="{{ $cosmetic->id }}">Xem
                                            </a>
                                            <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer"><a
                                                    href="#" data-id="{{ $cosmetic->id }}">Sửa</a></p>
                                            <a class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer user-delete"
                                               data-bs-toggle="modal" data-id="{{ $cosmetic->id }}"
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
                        <p>Sau khi bạn xoá mỹ phẩm này, bạn sẽ không thể hoàn tác việc xoá, có xác nhận xoá?</p>
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
                    <p class="mt-3">Xoá mỹ phẩm thành công.</p>
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
                    <h5 class="modal-title">Thông tin mỹ phẩm</h5>
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
                        <div id="appointment-history"></div>
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
                        console.log(response);
                        if (response.error) {
                            console.log(response.error);
                        } else {
                            let img = response.user.image == null ? "./img/logo.png" : response.user.image;
                            let dob = response.user.date_of_birth == null ? 'N/A' : response.user.date_of_birth;
                            dob = new Date(dob);
                            dob = dob.toLocaleDateString('vi-VN');
                            console.log(dob)
                            $('#user-image').attr('src', img);
                            $('input[name=full_name]').val(response.user.full_name);
                            $('input[name=email]').val(response.user.email);
                            $('input[name=phone_number]').val(response.user.phone_number);
                            $('input[name=address]').val(response.user.address);
                            $('input[name=date_of_birth]').val(dob);
                            $('input[name=note]').val(response.user.note);
                            $('#appointment-history').html(response.appointment_history);
                            $('#service-history').html(response.service_history);
                        }
                    },
                })
            });

            $('#delete-selected').click(function () {
                let selectedIds = [];
                $('.user-checkbox:checked').each(function () {
                    let id = $(this).attr('id').replace('check-', '');
                    selectedIds.push(id);
                });

                if (selectedIds.length > 0) {
                    let confirmDelete = confirm('Bạn có chắc muốn xoá những mỹ phẩm đã chọn?\nThao tác này không thể hoàn tác.');
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
                                console.log(response.error);
                            } else {
                                location.reload();
                            }
                        },
                    });
                }
            });

            let urlParams = new URLSearchParams(window.location.search);
            let cosmeticsPerPage = urlParams.get('cosmeticsPerPage');
            let search = urlParams.get('search');
            if (cosmeticsPerPage) {
                $('#cosmeticsPerPage').val('?cosmeticsPerPage=' + cosmeticsPerPage + '&page={{ $cosmetics->currentPage() }}');
            } else {
                $('#cosmeticsPerPage').val('?cosmeticsPerPage=10&page={{ $cosmetics->currentPage() }}');
            }
            if (search) {
                $('#search-customers').val(search);
                if (search) {
                    $('#back-button').attr('style', 'display: block');
                    $('#back-button').click(function () {
                        window.location.href = '/user-management';
                    });
                }
            }
        });

    </script>
@endsection

