@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Chi tiết khách hàng'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="alert alert-white" role="alert">
                <strong>Khách có sinh nhật trong 15 ngày tới: </strong>
                <br>
                @foreach($users as $user)
                    @if($user->role == 'admin')
                        @continue
                    @endif
                    @if($user->date_of_birth != null)
                        @php
                            $birthday = date('m-d', strtotime($user->date_of_birth));
                            $in15days = date('m-d', strtotime('+15 days'));
                        @endphp
                        @if($birthday <= $in15days)
                            <a href="#" class="user-details" data-id="{{ $user->id }}">
                                <span class="text-primary">{{ $user->full_name }}</span>
                                <span
                                    class="text-primary">({{ Carbon::parse($user->date_of_birth)->format('d/m/Y') }})</span>
                                <br>
                            </a>
                        @endif
                    @endif
                @endforeach
            </div>
            <div class="card mb-4 px-3">
                <div class="row">
                    <div class="card-header pb-0">
                        <h6>Thêm khách hàng mới</h6>
                    </div>
                    <div class="d-flex justify-content-start align-self-auto py-1 px-2">
                        <button class="btn bg-gradient-secondary">Thêm khách hàng</button>
                        <div class="dropdown ps-2">
                            <button class="btn bg-gradient-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Nhập / xuất file
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <form action="/users/import" method="POST" enctype="multipart/form-data" class="dropdown-item">
                                        @csrf
                                        <input type="file" name="file" accept=".xlsx">
                                        <button type="submit">Nhập từ Excel</button>
                                    </form>
                                </li>
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

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 min-height-600">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                    Họ tên
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Số
                                    điện thoại
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Email
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ngày sinh
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Địa
                                    chỉ
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tình trạng da
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ghi
                                    chú
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Ngày tạo
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Ngày cập nhật
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Hành động
                                </th>
                            </tr>
                            </thead>
                            <tbody id="customers-table">
                            @foreach($users as $user)
                                @if($user->role == 'admin')
                                    @continue
                                @endif
                                <tr>
                                    <td class="search-name">
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img
                                                    src="{{ $user->avatar == null ? "./img/logo.png" : $user->avatar }}"
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
                                    <td class="align-middle text-start text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->date_of_birth != null ? $user->date_of_birth->format('d/m/Y') : 'N/A'}}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm ml-1">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->address }}</p>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->skin_condition }}</p>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->note }}</p>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->updated_at->format('d/m/Y') }}</p>
                                    </td>

                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">

                                            <p class="text-sm font-weight-bold mb-0 cursor-pointer"><a
                                                    href="#" class="user-details" data-id="{{ $user->id }}">Xem</a>
                                            </p>
                                            <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer"><a
                                                    href="#" class="user-details" data-id="{{ $user->id }}">Sửa</a></p>
                                            <a class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer"
                                               data-bs-toggle="modal" data-bs-target="#modal-notification">Xoá</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    <button type="button" class="btn btn-danger">Xoá</button>
                    <button type="button" class="btn btn-default ml-auto" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.user-details').click(function (e) {
                console.log('clicked')
                e.preventDefault();

                const userId = $(this).data('id');

                $.ajax({
                    url: '/user-details/' + userId,
                    type: 'GET',
                    success: function (response) {
                        console.log(response);

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#search-customers').keyup(function (e) {
                let value = $(this).val().toLowerCase();
                $("#customers-table tr").each(function () {
                    let name = $(this).find('.search-name').text().toLowerCase();
                    let phone = $(this).find('.search-phone').text().toLowerCase();
                    $(this).toggle(name.indexOf(value) > -1 || phone.indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection
