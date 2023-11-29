@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Đơn hàng'])
    <div class="card shadow-lg mx-4 card-profile">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            Tạo đơn hàng mới
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Nhập thông tin đơn hàng
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
            <div class="col-md-7">
                <div class="card">
                    <form id="create-invoice" role="form" method="POST"
                          action={{ route('invoice.create') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-start">
                                <button type="submit" class="btn btn-primary btn-sm ">Lưu</button>
                                <button type="reset" class="btn btn-secondary btn-sm ms-2">Reset</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3">
                                THÔNG TIN KHÁCH HÀNG
                            </h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label for="find_customer" class="form-control-label w-100">Chọn khách hàng
                                            <input class="form-control" type="text" name="find_customer"
                                                   id="find_customer"
                                                   value=""></label>
                                        <ul id="customer-list"
                                            class="list-group list-group-content position-absolute w-100 left-0 right-0 bottom--1"></ul>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <h5 class="mb-3">
                                THÔNG TIN ĐƠN HÀNG
                            </h5>
                            <p class="text-uppercase text-sm">Liệu trình</p>
                            <div class="row">
                                <div id="treatmentFields">
                                    <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="find_treatment" class="form-control-label w-100">Chọn liệu
                                                    trình
                                                    <input class="find_treatment form-control" type="text"
                                                           name="find_treatment[]"
                                                           value=""></label>
                                                <ul id="treatment-list-0"
                                                    class="list-group list-group-content position-absolute left-0 right-0 bottom--1"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="treatment_qty-0" class="form-control-label w-100">Số lượng
                                                    <input class="form-control input-number treatment_qty" type="number"
                                                           name="treatment_qty[]" min="1"
                                                           id="treatment_qty-0"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn" id="removeTreatment">
                                                -
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-icon w-10 text-center center"
                                            id="addTreatment">
                                        <i class="ni ni-fat-add"></i>
                                    </button>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Mỹ phẩm</p>
                                <div id="cosmeticFields">
                                    <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="find_cosmetic" class="form-control-label w-100">Chọn mỹ phẩm
                                                    <input class="find_cosmetic form-control" type="text"
                                                           name="find_cosmetic[]"
                                                           value=""></label>
                                                <ul id="cosmetic-list-0"
                                                    class="list-group list-group-content position-absolute left-0 bottom--1"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cosmetic_qty-0" class="form-control-label w-100">Số lượng
                                                    <input class="cosmetic_qty form-control input-number" type="number"
                                                           name="cosmetic_qty[]" min="1"
                                                           id="cosmetic_qty-0"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn" id="removeCosmetic">
                                                -
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-icon w-10 center" id="addCosmetic">
                                        <i class="ni ni-fat-add"></i>
                                    </button>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Ghi chú</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note" class="form-control-label w-100">Ghi chú
                                            <textarea class="form-control" id="note" name="note"></textarea>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-profile">
                    <img src="/img/logo.png" alt="cover" class="card-img-top center m-auto mt-2"
                         style="max-width: 64px">
                    <div class="card-body pt-0">
                        <div class="text-center mt-4">
                            <h5>
                                THÔNG TIN ĐƠN HÀNG
                            </h5>
                            <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i>Allure Spa
                            </div>
                            <div class="row">
                                <div id="invoice-print-area">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        $(document).ready(function () {
            let treatmentsList = [];
            let cosmeticsList = [];
            let customerName = null;

            let treatmentCounter = 0;
            let cosmeticCounter = 0;
            let currentField = null;
            const treatmentFields = $('#treatmentFields');
            const cosmeticFields = $('#cosmeticFields');

            function handleSearch(input, url, listSelector, responseHandler) {
                if (input.length >= 1) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {q: input},
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            const list = $(listSelector);
                            list.empty();
                            if (response.error) {
                                list.append('<li class="list-group-item list-group-item-danger">Không tìm thấy</li>');
                            } else {
                                responseHandler(response, list);
                            }
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                }
            }

            function handleTreatmentSearch(input, field) {
                handleSearch(input, '/treatment-management-search', '#treatment-list-' + field, function (response, list) {
                    let treatments = response.treatments;
                    treatments.forEach(treatment => {
                        list.append('<li class="list-group-item list-group-item-action cursor-pointer" data-id="' + treatment.id + '">' + treatment.treatment_name + ' - Giá: ' + treatment.price + '</li>');
                    });

                    list.find('.list-group-item').on('click', function () {
                        let selectedValue = $(this).text();
                        let price = $(this).text().split(' - Giá: ')[1];
                        let treatmentName = $(this).text().split(' - Giá: ')[0];
                        let selectedId = $(this).attr('data-id');
                        currentField.val(selectedValue).attr('data-id', selectedId);
                        list.empty();
                        let quantity = currentField.closest('.col-md-12').find('#treatment_qty-' + field).val(1).val();
                        treatmentsList.push({id: selectedId, name: treatmentName, price: price, quantity: quantity});
                        console.log(treatmentsList)
                    });
                });
            }

            function handleCosmeticSearch(input, field) {
                handleSearch(input, '/cosmetic-management-search', '#cosmetic-list-' + field, function (response, list) {
                    let cosmetics = response.cosmetics;
                    cosmetics.forEach(cosmetic => {
                        list.append('<li class="list-group-item list-group-item-action cursor-pointer" data-id="' + cosmetic.id + '">' + cosmetic.cosmetic_name + ' - Giá: ' + cosmetic.price + '</li>');
                    });

                    list.find('.list-group-item').on('click', function () {
                        let selectedValue = $(this).text();
                        let price = $(this).text().split(' - Giá: ')[1];
                        let cosmeticName = $(this).text().split(' - Giá: ')[0];
                        let selectedId = $(this).attr('data-id');
                        currentField.val(selectedValue).attr('data-id', selectedId);
                        list.empty();
                        let quantity = currentField.closest('.col-md-12').find('#cosmetic_qty-' + field).val(1).val();
                        cosmeticsList.push({id: selectedId, name: cosmeticName, price: price, quantity: quantity});
                        console.log(cosmeticsList)
                    });
                });
            }

            function handleCustomerSearch(input) {
                handleSearch(input, '/user-management-search', '#customer-list', function (response, list) {
                    let users = response.users;
                    users.forEach(user => {
                        list.append('<li class="list-group-item list-group-item-action cursor-pointer" data-id="' + user.id + '">' + user.full_name + ' - SĐT: ' + user.phone_number + '</li>');
                    });

                    list.find('.list-group-item').on('click', function () {
                        let selectedValue = $(this).text();
                        customerName = $(this).text().split(' - SĐT: ')[0];
                        $('#find_customer').val(selectedValue).attr('data-id', $(this).attr('data-id'));
                        list.empty();
                    });
                });
            }

            $('#find_customer').on('input', function () {
                let input = $(this).val();
                handleCustomerSearch(input);
            });

            $('#addTreatment').on('click', function (e) {
                e.preventDefault();
                treatmentCounter++;
                treatmentFields.append(`
            <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="find_treatment" class="form-control-label w-100">Chọn liệu trình
                            <input class="find_treatment form-control" type="text" name="find_treatment[]"
                                   value=""></label>
                        <ul id="treatment-list-${treatmentCounter}"
                            class="list-group list-group-content position-absolute left-0 right-0 bottom--1"></ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="treatment_qty-${treatmentCounter}" class="form-control-label w-100">Số lượng
                            <input class="form-control input-number" type="number"
                                   name="treatment_qty[]"
                                   id="treatment_qty-${treatmentCounter}" min="1"
                                   value=""></label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn" id="removeTreatment">
                        -
                    </button>
                </div>
            </div>
        `);

                $('.find_treatment').last().on('input', function () {
                    let input = $(this).val();
                    currentField = $(this);
                    handleTreatmentSearch(input, treatmentCounter);
                });

                $('#treatment_qty-' + treatmentCounter).on('change', function () {
                    console.log('change')
                    let newQuantity = $(this).val();
                    let treatmentId = $(this).closest('.col-md-12').find('.find_treatment').attr('data-id');
                    let treatment = treatmentsList.find(treatment => treatment.id === treatmentId);
                    if (treatment) {
                        treatment.quantity = newQuantity;
                    }
                    console.log(treatmentsList)
                });
            });

            $('.find_treatment').first().on('input', function () {
                let input = $(this).val();
                currentField = $(this);
                handleTreatmentSearch(input, 0);
            });

            $('#treatment_qty-' + treatmentCounter).on('change', function () {
                let newQuantity = $(this).val();
                let treatmentId = $(this).closest('.col-md-12').find('.find_treatment').attr('data-id');
                let treatment = treatmentsList.find(treatment => treatment.id === treatmentId);
                if (treatment) {
                    treatment.quantity = newQuantity;
                }
            });

            $('#addCosmetic').on('click', function (e) {
                e.preventDefault();
                cosmeticCounter++;
                cosmeticFields.append(`
        <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="find_cosmetic" class="form-control-label w-100">Chọn mỹ phẩm
                        <input class="find_cosmetic form-control" type="text" name="find_cosmetic[]"
                               value=""></label>
                    <ul id="cosmetic-list-${cosmeticCounter}"
                        class="list-group list-group-content position-absolute left-0 right-0 bottom--1"></ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="cosmetic_qty-${cosmeticCounter}" class="form-control-label w-100">Số lượng
                        <input class="form-control input-number" type="number"
                               name="cosmetic_qty[]"
                               id="cosmetic_qty-${cosmeticCounter}" min="1"
                               value=""></label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn" id="removeCosmetic">
                    -
                </button>
            </div>
        </div>
    `);

                $('.find_cosmetic').last().on('input', function () {
                    let input = $(this).val();
                    currentField = $(this);
                    handleCosmeticSearch(input, cosmeticCounter);
                });

                $('#cosmetic_qty-' + cosmeticCounter).on('change', function () {
                    let newQuantity = $(this).val();
                    let cosmeticId = $(this).closest('.col-md-12').find('.find_cosmetic').attr('data-id');
                    let cosmetic = cosmeticsList.find(cosmetic => cosmetic.id === cosmeticId);
                    if (cosmetic) {
                        cosmetic.quantity = newQuantity;
                    }
                });

            });

            $('.find_cosmetic').first().on('input', function () {
                let input = $(this).val();
                currentField = $(this);
                handleCosmeticSearch(input, 0);
            });

            $('#cosmetic_qty-' + cosmeticCounter).on('change', function () {
                let newQuantity = $(this).val();
                let cosmeticId = $(this).closest('.col-md-12').find('.find_cosmetic').attr('data-id');
                let cosmetic = cosmeticsList.find(cosmetic => cosmetic.id === cosmeticId);
                if (cosmetic) {
                    cosmetic.quantity = newQuantity;
                }
            });

            $('#create-invoice').on('submit', function (e) {
                e.preventDefault();
                console.log('submit')

                let customerId = $('#find_customer').attr('data-id');
                let note = $('#note').val();

                $('#invoice-print-area').empty().append(`
                            <div class="text-left">
                <h5 class="mb-0">Khách hàng: ${customerName}</h5>
                <p class="mb-0">Ghi chú: ${note === '' ? 'Không' : note}</p>
                            </div>
                            <div class="table">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Tên dịch vụ</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                `);

                treatmentsList.forEach(treatment => {
                    $('#invoice-print-area tbody').append(`
                        <tr>
                            <td>${treatment.name}</td>
                            <td>${treatment.quantity}</td>
                            <td>${treatment.price}</td>
                            <td>${treatment.price * treatment.quantity}</td>
                        </tr>
                    `);
                });

                cosmeticsList.forEach(cosmetic => {
                    $('#invoice-print-area tbody').append(`
                        <tr>
                            <td>${cosmetic.name}</td>
                            <td>${cosmetic.quantity}</td>
                            <td>${cosmetic.price}</td>
                            <td>${cosmetic.price * cosmetic.quantity}</td>
                        </tr>
                    `);
                });
            });

            $(document).on('click', '#removeTreatment', function () {
                $(this).closest('.col-md-12').remove();
            });

            $(document).on('click', '#removeCosmetic', function () {
                $(this).closest('.col-md-12').remove();
            });

        });
    </script>
@endsection
