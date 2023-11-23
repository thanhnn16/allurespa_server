@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Thêm khách hàng'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/logo.png" alt="profile_image"
                             class="w-100 border-radius-lg shadow-sm max-height-250s">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            Thêm khách hàng mới
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Nhập thông tin chi tiết khách hàng
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Thêm khách hàng mới</p>
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-dark btn-sm" onclick="window.history.back()">
                                        Quay lại
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Hình ảnh</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Thêm hình ảnh khách
                                            hàng</label>
                                        <input class="form-control" type="file" name="image" id="image"
                                               accept="image/*"
                                        >
                                        <div class="max-height-100 max-width-100 mt-3">
                                            <img id="avatar" src="/img/logo.png"
                                                 class="w-100 h-100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">THÔNG TIN CÁ NHÂN</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                        <input class="form-control" type="tel" name="phone_number"
                                               placeholder="Số điện thoại"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Địa chỉ Email</label>
                                        <input class="form-control" type="email" name="email" placeholder="Email"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                        <input class="form-control" type="text" name="full_name"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                        <input class="form-control" type="date" name="date_of_birth"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                        <input class="form-control" type="text" name="address"
                                               value="">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Thông tin thêm</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="skin_condition" class="form-control-label">Tình trạng da</label>
                                        <textarea class="form-control" type="text" name="skin_condition"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note" class="form-control-label">Ghi chú</label>
                                        <textarea class="form-control" type="password" name="note"
                                        ></textarea>
                                    </div>
                                </div>

                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex align-items-center">
                                <button type="reset" class="btn btn-dark me-3">Reset</button>
                                <button type="submit" class="btn btn-primary me-3">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        $('input[type="file"]').on('change', function () {
            let reader = new FileReader();
            reader.onload = function (e) {
                console.log(e.target.result);
                $('#avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection

