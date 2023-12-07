@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Thêm mỹ phẩm'])
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
                            Thêm khách mỹ phẩm
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Nhập thông tin chi tiết mỹ phẩm
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
                    <form role="form" method="POST" id="form-add-cosmetic"
                          action={{ route('user-management.store') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Thêm mỹ phẩm mới</p>
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
                                    <label class="form-control-label ms-auto mb-4">Thêm hình ảnh mỹ phẩm</label>
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
                                none;" class="img-thumbnail max-width-200">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">THÔNG TIN MỸ PHẨM</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tên mỹ phẩm</label>
                                        <input class="form-control" type="text" name="cosmetic_name" id="cosmetic_name"
                                               placeholder="Tên mỹ phẩm" required maxlength="255"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cosmetic_price">Giá mỹ phẩm</label>
                                        <input type="number" class="form-control" id="price"
                                               name="price" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cosmetic_category_id">Loại mỹ phẩm</label>
                                        <select class="form-control" id="cosmetic_category_id" name="cosmetic_category_id" required>
                                            <option value="">Chọn loại mỹ phẩm</option>
                                            @foreach($cosmeticCategories as $cosmeticCategory)
                                                <option value="{{ $cosmeticCategory->id }}">{{ $cosmeticCategory->cosmetic_category_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cosmetic_description">Mô tả mỹ phẩm</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mục tiêu</label>
                                        <input class="form-control" type="text" name="purpose" id="purpose"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Cách dùng</label>
                                        <input class="form-control" type="text" name="how_to_use" id="how_to_use"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Thành phần</label>
                                        <input class="form-control" type="text" name="ingredients" id="ingredients"
                                               value="">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
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
                    <p class="mt-3">Thêm mỹ phẩm mới thành công.</p>
                    <button type="button" class="btn btn-sm mt-3 btn-gradient-dark" id="ok-button"
                            data-bs-dismiss="modal">
                        Quay lại
                    </button>
                    <button type="button" class="btn btn-sm mt-3 btn-success" id="add-more-button"
                            data-bs-dismiss="modal">Thêm tiếp
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
                const formData = new FormData($('#form-add-cosmetic')[0]);
                for (const pair of formData.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }

                const image = $('#image');
                if (image.val()) {
                    const file = dataURLtoFile(croppedImageDataURL, $('#cosmetic_name').val() + '.png');
                    formData.append('image', file);
                    console.log('filename: ' + file.name);
                }
                $.ajax({
                    url: '{{ route('cosmetic-management.store') }}',
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
                            $('#statusSuccessModal').modal('show');
                            $('#ok-button').on('click', function () {
                                window.location.href = '{{ route('cosmetic-management') }}';
                            });
                            $('#add-more-button').on('click', function () {
                                window.location.href = '{{ route('cosmetic-management.create') }}';
                            });

                        }
                    },
                    error: function (data) {
                        console.log(data);
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

