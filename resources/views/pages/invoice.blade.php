@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <style>
        .payment_layer {
            display: none;
            position: fixed;
            _position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
        }

        .payment_layer .payment_bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            opacity: .5;
            filter: alpha(opacity=50);
        }

        .payment_layer .payment_pop_layer {
            display: block;
        }

        .payment_pop_layer {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 800px;
            height: 650px;
            background-color: #fff;
            z-index: 9999;
        }

        .payment_pop_layer .payment_pop_container {
            width: 100%;
            height: 100%;
            padding: 0px;
        }

        .payment_pop_conts {
            width: 100%;
            height: 100%;
            padding: 0px;
        }

        .payment_pop_layer_origin {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 510px;
            height: auto;
            background-color: #fff;
            border: 5px solid #ff0d0d;
            z-index: 9999;
        }

        .setDiv {
            padding-top: 100px;
            text-align: center;
        }

        .mask {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 9999;
            background-color: #000;
            display: none;
        }

        .window {
            display: none;
            background-color: #ffffff;
            height: 200px;
            z-index: 99999;
        }
    </style>
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
            <div class="col-md-12">
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
                            <p class="text-uppercase text-sm">Voucher</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="voucher"
                                               placeholder="Nhập mã giảm giá ở đây" name="voucher"/>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Ghi chú</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="note" name="note">Không</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pb-0">
                            <div class="d-flex align-items-center justify-content-start">
                                <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                                <button type="reset" class="btn btn-secondary btn-sm ms-2">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card card-profile">
                    <img src="/img/logo.png" alt="cover" class="card-img-top center m-auto mt-2"
                         style="max-width: 64px">
                    <div class="card-body pt-0">
                        <div class="text-center mt-2">
                            <h3 class="mb-0">Allure Spa</h3>
                            <div class="h6">
                                <i class="ni location_pin mr-2"></i>Mã đơn hàng: <span id="invoiceId">#</span>
                            </div>
                            <div class="row">
                                <div class="col-12 text-start">
                                    Khách hàng: <span id="customerName"></span>
                                </div>
                                <div class="col-12 text-start">
                                    Ghi chú: <span id="noteBill"></span>
                                </div>
                                <div class="col-12 text-start">
                                    Ngày tạo: <span id="createdDate"></span>
                                </div>
                                <div class="col-12">
                                    <table id="bill-table" class="table table-borderless">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="text-sm">STT</th>
                                            <th class="text-sm">Tên dịch vụ</th>
                                            <th class="text-sm">Đơn giá</th>
                                            <th class="text-sm">Số lượng</th>
                                            <th class="text-sm">Thành tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bill-table-body">
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end">Tổng tiền</td>
                                            <td class="text-end">0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Giảm giá</td>
                                            <td class="text-end">0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Tổng cộng</td>
                                            <td class="text-end" id="payment-total">0</td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <div class="text-center">
                                        <form id="megapayForm" name="megapayForm" method="POST">
                                            <input type="hidden" name="merId" value="EPAY000001">
                                            <input type="hidden" name="merTrxId" value="">
                                            <input type="hidden" name="encodeKey"
                                                   value="rf8whwaejNhJiQG2bsFubSzccfRc/iRYyGUn6SPmT6y/L7A2XABbu9y4GvCoSTOTpvJykFi6b1G0crU8et2O0Q==">
                                            <input type="hidden" name="currency" value="VND">
                                            <input type="hidden" name="amount" data-amount="" value="">
                                            <input type="hidden" name="invoiceNo" value="">
                                            <input type="hidden" name="goodsNm" value="">
                                            <input type="hidden" name="callBackUrl"
                                                   value="http://127.0.0.1:8000/invoice">
                                            <input type="hidden" name="notiUrl"
                                                   value="http://127.0.0.1:8000/invoice">
                                            <input type="hidden" name="reqDomain" value="http://localhost:8000">
                                            <input type="hidden" name="description" value="Thanh toan cho Allure Spa">
                                            <input type="hidden" name="merchantToken" value="">
                                            <input type="hidden" name="userLanguage" value="VN">
                                            <input type="hidden" name="timeStamp" value="">
                                            <input type="hidden" name="windowColor" value="">
                                            <input type="hidden" name="windowType" value="">
                                            <div class="row text-start">
                                                <h6 class="text-uppercase text-sm">Hình thức thanh toán</h6>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="QR" name="payType"
                                                           value="QR" checked>Mã QR
                                                    <label class="form-check-label" for="QR">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="EW" name="payType"
                                                           value="EW">Ví điện tử
                                                    <label class="form-check-label" for="EW"><span>
                                                    </span></label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="IC" name="payType"
                                                           value="IC">Thẻ tín dụng
                                                    <label class="form-check-label">
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" onclick="" id="btn-pay"
                                                    class="btn btn-primary btn-sm">
                                                Thanh toán
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm" id="printInvoice">
                                                In hóa đơn
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" id="cancelInvoice">
                                                Hủy hóa đơn
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.10.1/sha256.min.js"
            integrity="sha512-gjZp+u3skha2P8XAalYmFTjvJIXTOvdVceRoXoEnDkkXJE8p0dTV2HEKBcynXZxbuQZglD+MNRIKKKI8dKUX7Q=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://sandbox.megapay.vn/pg_was/js/payment/layer/paymentClient.js"></script>


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

                $('#bill-table-body').empty();

                $('#customerName').text(customerName);
                $('#noteBill').text(note);
                $('#createdDate').text(moment().format('HH:mm:ss - DD/MM/YYYY'));

                $('#bill-table-body').append(`
                    <tr>
                        <td colspan="5" class="text-center"><b>Liệu trình</b></td>
                    </tr>
                `);

                treatmentsList.forEach((treatment, index) => {
                    $('#bill-table-body').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${treatment.name}</td>
                        <td>${treatment.price}</td>
                        <td>${treatment.quantity}</td>
                        <td>${treatment.price * treatment.quantity}</td>
                    </tr>
                `);
                });

                $('#bill-table-body').append(`
                    <tr>
                        <td colspan="5" class="text-center"><b>Mỹ phẩm</b></td>
                    </tr>
                `);

                cosmeticsList.forEach((cosmetic, index) => {
                    $('#bill-table-body').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${cosmetic.name}</td>
                        <td>${cosmetic.price}</td>
                        <td>${cosmetic.quantity}</td>
                        <td>${cosmetic.price * cosmetic.quantity}</td>
                    </tr>
                `);
                });

                let total = 0;
                treatmentsList.forEach(treatment => {
                    total += treatment.price * treatment.quantity;
                });
                cosmeticsList.forEach(cosmetic => {
                    total += cosmetic.price * cosmetic.quantity;
                });
                $('#payment-total').text(total);

            });

            $('#btn-pay').on('click', function (e) {
                e.preventDefault();
                $('#megapayForm').find('input[name="timeStamp"]').val(moment().format('YYYYMMDDHHmmss'));
                let timeStamp = $('#megapayForm').find('input[name="timeStamp"]').val();

                let merId = $('#megapayForm').find('input[name="merId"]').val();

                $('#megapayForm').find('input[name="merTrxId"]').val(`${merId + timeStamp + Math.floor(Math.random() * 1000000)}`);
                let merTrxId = $('#megapayForm').find('input[name="merTrxId"]').val();

                let goodsNm = '';
                treatmentsList.forEach(treatment => {
                    goodsNm += `${treatment.name} x ${treatment.quantity}, `;
                });
                cosmeticsList.forEach(cosmetic => {
                    goodsNm += `${cosmetic.name} x ${cosmetic.quantity}, `;
                });

                $('#megapayForm').find('input[name="goodsNm"]').val(goodsNm);

                $('#megapayForm').find('input[name="invoiceNo"]').val("ORD_" + timeStamp);

                $('#megapayForm').find('input[name="amount"]').val($('#payment-total').text());

                let amount = $('#megapayForm').find('input[name="amount"]').val();

                let encodeKey = $('#megapayForm').find('input[name="encodeKey"]').val();

                let merchantToken = sha256(`${timeStamp}${merTrxId}${merId}${amount}${encodeKey}`);

                $('#megapayForm').find('input[name="merchantToken"]').val(merchantToken);

                openPayment(1, "https://sandbox.megapay.vn");
            });

        });

        $(document).on('click', '#removeTreatment', function () {
            $(this).closest('.col-md-12').remove();
        });

        $(document).on('click', '#removeCosmetic', function () {
            $(this).closest('.col-md-12').remove();
        });

        // $('#btn-pay').on('click', function (e) {
        //     e.preventDefault();
        //     $.ajax({
        //             url: 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
        //             type: 'POST',
        //             data: {
        //                 vnp_Version: "2.1.0",
        //                 vnp_Command: "pay",
        //                 vnp_TmnCode: "TFL3IR0W",
        //                 vnp_Amount: 100000,
        //                 vnp_CreateDate: "20210823111111",
        //                 vnp_CurrCode: "VND",
        //                 vnp_IpAddr: "192.168.1.30",
        //                 vnp_Locale: "vn",
        //                 vnp_OrderInfo: "Thanh toan don hang",
        //                 vnp_ReturnUrl: "http://localhost:8000/invoice",
        //                 vnp_TxnRef: "EPAY0000011",
        //                 vnp_SecureHash: "KNPYLTFSMETODQGJMDYDQHTCXSFRDQIE",
        //             },
        //             headers: {
        //                 'Accept': 'application/json',
        //             },
        //             success: function (response) {
        //                 console.log(response)
        //             },
        //             error: function (response) {
        //                 console.log(response);
        //             }
        //
        //         }
        //     )
        // });


    </script>

@endsection
