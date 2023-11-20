@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="alert alert-light" role="alert">
                <strong>Khách có sinh nhật trong 15 ngày tới: </strong>

            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Danh sách khách hàng</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
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
                            <tbody>

                            <tbody>
                            @foreach($users as $user)
                                <a href="{{ route('user-details', ['id' => $user->id]) }}">

                                    <tr>
                                        <td>
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
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->phone_number }}</p>
                                        </td>
                                        <td class="align-middle text-start text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->date_of_birth != null ? $user->date_of_birth->format('d/M/Y') : 'N/A'}}</p>
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
                                                <p class="text-sm font-weight-bold mb-0 cursor-pointer">Sửa</p>
                                                <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Xoá</p>
                                            </div>
                                        </td>
                                    </tr>
                                </a>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
