@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Thêm khách hàng'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
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
                    <form role="form" method="POST"
                          action={{ route('user-management.store') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Thêm khách hàng mới</p>
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-dark btn-sm" onclick="window.history.back()">
                                        Quay lại
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-add">Thêm</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Hình ảnh</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label ms-auto mb-4">Thêm hình ảnh khách
                                        hàng</label>
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="image" id="image"
                                               accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-1">
                                    <div class="d-flex justify-content-start">
                                        <img id="croppedImage" src="#" alt="Cropped image" style="display:
                                none;" class="img-thumbnail">
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
                                               placeholder="Số điện thoại" required maxlength="13" minlength="10"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Địa chỉ Email</label>
                                        <input class="form-control" type="email" name="email" placeholder="Email"
                                               required
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Họ và tên</label>
                                        <input class="form-control" type="text" name="full_name" required
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
                                        <label for="gender" class="form-control-label">Giới tính</label>
                                        <select name="gender" class="form-select">
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
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
                            <div class="message">
                            </div>
                            <hr class="horizontal dark">
                            <div class="d-flex align-items-center">
                                <button type="reset" class="btn btn-dark me-3">Reset</button>
                                <button type="submit" class="btn btn-primary me-3 btn-add">Thêm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
        <div class="modal-dialog ms-auto modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropImageModalLabel">Cắt ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div
                        class="img-container flex justify-content-center align-items-center w-100 height-500 overflow-hidden">
                        <img id="imageToCrop" src="#" class="w-100 img-center"
                             alt="Image to crop">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-primary" id="cropAndUpload">Cắt và tải lên
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let cropper;
            let croppedImageDataURL;
            const cropImageModal = $('#cropImageModal');
            cropImageModal.on('shown.bs.modal', function () {
                cropper = new Cropper($('#imageToCrop') [0], {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                });
            });
            cropImageModal.on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });


            $('#image').on('change', function (event) {
                    const file = event.target.files[0];
                    const fileReader = new FileReader();
                    fileReader.onload = function (e) {
                        $('#imageToCrop').attr('src', e.target.result);
                        $('#cropImageModal').modal('show');
                    };
                    fileReader.readAsDataURL(file);
                }
            );
            $('#cropAndUpload').on('click', function () {
                croppedImageDataURL = cropper.getCroppedCanvas().toDataURL();
                showCroppedImage();
                cropImageModal.modal('hide');
            });

            function showCroppedImage() {
                const croppedImage = $('#croppedImage');
                croppedImage.attr('src', croppedImageDataURL);
                croppedImage.show();
            }

            function dataURLtoFile(dataurl, filename) {
                let arr = dataurl.split(','),
                    mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[1]),
                    n = bstr.length,
                    u8arr = new Uint8Array(n);
                while (n--) {
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new File([u8arr], filename, {type: mime});
            }

            $('.btn-add').on('click', function (e) {
                e.preventDefault();
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('full_name', $('input[name="full_name"]').val());
                formData.append('email', $('input[name="email"]').val());
                formData.append('phone_number', $('input[name="phone_number"]').val());
                formData.append('date_of_birth', $('input[name="date_of_birth"]').val());
                formData.append('gender', $('select[name="gender"]').val());
                formData.append('address', $('input[name="address"]').val());
                formData.append('skin_condition', $('textarea[name="skin_condition"]').val());
                formData.append('note', $('textarea[name="note"]').val());
                console.log(formData.get('date_of_birth'));

                const image = $('#image');
                if (image.val()) {
                    const file = dataURLtoFile(croppedImageDataURL, formData.get('phone_number') + '.png');
                    formData.append('image', file);
                    console.log('filename: ' + file.name);
                    console.log(formData.get('image'));
                }
                $.ajax({
                    url: '{{ route('user-management.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response.data);
                        if (response.error) {
                            $('.message').html(`<p class="text-danger">${response.error}</p>`);
                        } else if (response.success) {
                            $('.message').html(`<p class="text-success">${response.success}</p>`);
                            setTimeout(function () {
                                window.location.href = '{{ route('user-management') }}';
                            }, 50000);
                        }
                    },
                    error: function (data) {
                        console.log(data.responseJSON);
                        let errors = data.responseJSON.errors;
                        let errorMessages = '';
                        for (const key in errors) {
                            errorMessages += `<p class="text-danger">${errors[key]}</p>`;
                        }
                        $('.message').html(errorMessages);

                    }
                });
            });

        });
    </script>
@endsection

