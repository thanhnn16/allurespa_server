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
            <div class="col-md-8">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">THÔNG TIN KHÁCH HÀNG</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label for="find_customer" class="form-control-label w-100">Chọn khách hàng
                                            <input class="form-control" type="text" name="find_customer"
                                                   id="find_customer"
                                                   value=""></label>
                                        <ul id="customer-list" class="position-absolute"></ul>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">THÔNG TIN ĐƠN HÀNG</p>
                            <div class="row">
                                <div id="treatmentFields">
                                    <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="find_treatment" class="form-control-label w-100">Chọn liệu
                                                    trình
                                                    <input class="form-control" type="text" name="find_treatment[]"
                                                           id="find_treatment"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="treatment_qty" class="form-control-label w-100">Số lượng
                                                    <input class="form-control input-number" type="number"
                                                           name="treatment_qty[]"
                                                           id="treatment_qty" min="1"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn" id="removeTreatment">
                                                -
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm" id="addTreatment">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <hr class="horizontal dark">
                                <div id="cosmeticFields">
                                    <div class="col-md-12 d-flex flex-row justify-content-between align-items-center">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="find_cosmetic" class="form-control-label w-100">Chọn mỹ phẩm
                                                    <input class="form-control" type="text" name="find_cosmetic[]"
                                                           id="find_cosmetic"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cosmetic_qty" class="form-control-label w-100">Số lượng
                                                    <input class="form-control input-number" type="number"
                                                           name="cosmetic_qty[]"
                                                           id="cosmetic_qty" min="1"
                                                           value=""></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn" id="removeCosmetic">
                                                -
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm" id="addCosmetic">
                                        <i class="fas fa-plus"></i>
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
            <div class="col-md-4">
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
                            <div id="invoice-print-area">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        $(document).ready(function() {
            $('#find_customer').on('input', function() {
                let input = $(this).val();
                if(input.length >= 1) {
                    $.ajax({
                        url: '/user-management/search',
                        type: 'GET',
                        data: { q: input },
                        header: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            let customerList = $('#customer-list');
                            customerList.empty();
                            if(response.error) {
                                customerList.append('<li>Không tìm thấy</li>');
                            } else {
                                response.forEach(function(customer) {
                                    customerList.append('<li>' + customer.name + '</li>');
                                });
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script>
@endsection
