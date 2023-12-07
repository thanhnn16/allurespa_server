@php use Carbon\Carbon; @endphp
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Quản lý hoá đơn'])
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

        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Danh sách hoá đơn</h6>
            </div>

            @if($invoices->isEmpty())
                <div class="alert">
                    <h4 class="text-center">Không có hoá đơn</h4>
                </div>
            @else
                <div class="align-self-auto d-flex py-1 px-3 pb-3">
                    <div class="input-group">
                        <input type="text" id="search-customers" class="form-control"
                               placeholder="Tìm kiếm mã hoá đơn / tên khách hàng"
                               aria-label="Tìm kiếm" aria-describedby="basic-addon2">
                        <span class="input-group-text"
                              id="basic-addon2"><i
                                class="fas fa-search"></i></span>
                    </div>
                </div>
                <button id="back-button" class="btn btn-secondary" style="display: none">Quay lại</button>

                <div class="form-group py-1 px-3 flex flex-row mt-3 justify-content-start align-items-center">
                    <label for="invoicesPerPage" class="form-label">Số hoá đơn trên mỗi trang: </label>
                    <select id="numUsersPerPage" class="form-select w-30" name="numUsersPerPage"
                            onchange="location = this.value;">
                        <option value="?invoicesPerPage=10&page=1">10</option>
                        <option value="?invoicesPerPage=20&page=1">20</option>
                        <option value="?invoicesPerPage=50&page=1">50</option>
                    </select>
                </div>

                <div class="pagination-info">
                    Trang {{ $invoices->currentPage() }} trên tổng số {{ $invoices->lastPage() }} trang

                    <ul class="pagination my-2">
                        @if ($invoices->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="{{ $invoices->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $invoices->previousPageUrl() }}" tabindex="-1"
                                   aria-disabled="true"><</a>
                            </li>
                        @endif
                        @for($i = 1; $i <= $invoices->lastPage(); $i++)
                            @if($invoices->currentPage() == $i)
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="{{ $invoices->url($i) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $invoices->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($invoices->hasMorePages())
                            <li class="page-item">
                                <a class="page-link {{ $invoices->currentPage() == $invoices->lastPage() ? 'active' : '' }}"
                                   href="{{ $invoices->nextPageUrl() }}">></a>
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
                                <th data-column="id" data-order="asc"
                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable">
                                    Mã hoá đơn
                                    <span class="fas fa-sort"></span>
                                </th>
                                <th data-column="full_name" data-order="asc"
                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable">
                                    Tên khách hàng
                                    <span class="fas fa-sort"></span>
                                </th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ngày tạo
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
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="align-middle text-center">
                                        <input type="checkbox"
                                               class="user-checkbox bg-gradient-faded-dark form-check-input"
                                               id="check-{{ $invoice->id }}">
                                    </td>
                                    <td class="search-name">
                                        <p class="mb-0 text-sm-center">
                                            #{{ $invoice->id == null ? 'N/A' : $invoice->id }}</p>
                                    </td>
                                    <td class="search-phone">
                                        <p class="text-sm font-weight-bold mb-0">{{ $invoice->full_name }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $invoice->created_at != null ? $invoice->created_at->format('d/m/Y H:m:s') : 'N/A'}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $invoice->note }}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="text-sm font-weight-bold mb-0 cursor-pointer"
                                               data-bs-toggle="modal"
                                               data-bs-target="#invoice-details"
                                               href="#" data-id="{{ $invoice->id }}">Xem
                                            </a>
                                            <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer"><a
                                                    href="#" data-id="{{ $invoice->id }}">Sửa</a></p>
                                            <a class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer user-delete"
                                               data-bs-toggle="modal" data-id="{{ $invoice->id }}"
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

    <div class="modal fade" tabindex="-1" id="invoice-details">
        <div class="modal-dialog modal-lg modal-dialog-scrollable ms-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin hoá đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                                <td class="text-end" id="payment-sum">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end">Giảm giá</td>
                                                <td class="text-end" id="payment-discount">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end">Tổng cộng</td>
                                                <td class="text-end" id="payment-total">0</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <div class="text-start">
                                            <span class="text-sm">Trạng thái đơn hàng</span>:
                                            <span class="text-sm" id="status"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.10.1/sha256.min.js"
            integrity="sha512-gjZp+u3skha2P8XAalYmFTjvJIXTOvdVceRoXoEnDkkXJE8p0dTV2HEKBcynXZxbuQZglD+MNRIKKKI8dKUX7Q=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://sandbox.megapay.vn/pg_was/js/payment/layer/paymentClient.js"></script>

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

            $('#modal-notification').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                $('#btn-delete').off('click').on('click', function (e) {
                    e.preventDefault();
                    $('#modal-notification').modal('hide');
                    $.ajax({
                        url: 'invoice-details/' + id,
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

            $('#invoice-details').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                console.log(id)
                $.ajax({
                    url: 'invoice-details/' + id,
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        if (response.error) {
                            sessionStorage.setItem('error', response.error);
                        } else {
                            let status = response.invoice.status === 'pending' ? 'Đang chờ xử lý' : response.invoice.status === 'processing' ? 'Đang xử lý' : response.invoice.status === 'completed' ? 'Hoàn thành' : 'Đã huỷ';
                            $('#invoiceId').text('#' + response.invoice.id);
                            $('#customerName').text(response.invoice.full_name);
                            $('#noteBill').text(response.invoice.note);
                            $('#createdDate').text(response.invoice.created_at);
                            $('#status').text(status);
                            $('#bill-table-body').empty();
                            let total = 0;
                            let paymentTotal = 0;
                            let i = 1;
                            response.invoiceTreatments.forEach(function (item) {
                                $('#bill-table-body').append('<tr>' +
                                    '<td>' + i + '</td>' +
                                    '<td>' + item.treatment_name + '</td>' +
                                    '<td>' + item.total_amount + '</td>' +
                                    '<td>' + item.treatment_quantity + '</td>' +
                                    '<td>' + item.total_amount * item.treatment_quantity + '</td>' +
                                    '</tr>');
                                total += item.total_amount * item.treatment_quantity;
                                i++;
                            });
                            response.invoiceCosmetics.forEach(function (item) {
                                $('#bill-table-body').append('<tr>' +
                                    '<td>' + i + '</td>' +
                                    '<td>' + item.cosmetic_name + '</td>' +
                                    '<td>' + item.total_amount + '</td>' +
                                    '<td>' + item.cosmetic_quantity + '</td>' +
                                    '<td>' + item.total_amount * item.cosmetic_quantity + '</td>' +
                                    '</tr>');
                                total += item.total_amount * item.cosmetic_quantity;
                                i++;
                            });

                            paymentTotal = total - (!response.invoice.discount ? 0 : response.invoice.discount);
                            $('#payment-sum').text(total);
                            $('#payment-discount').text(!response.invoice.discount ? 0 : response.invoice.discount);
                            $('#payment-total').text(paymentTotal);


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
                        url: '/invoice-details/delete-selected',
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
            let invoicesPerPage = urlParams.get('invoicesPerPage');
            let search = urlParams.get('search');
            let currentOrder = urlParams.get('order');

            $('.sortable').attr('style', 'cursor: pointer').click(function (e) {
                e.preventDefault();
                let order = $(this).attr('data-order');
                let column = $(this).attr('data-column');
                let arrow = '';
                if (currentOrder === 'desc') {
                    $(this).attr('data-order', 'asc');
                    order = 'asc';
                    arrow = '<span class="fas fa-sort-up"></span>';
                } else {
                    $(this).attr('data-order', 'desc');
                    order = 'desc';
                    arrow = '<span class="fas fa-sort-down"></span>';
                }

                let hrefString = '?invoicesPerPage=' + (invoicesPerPage ? invoicesPerPage : 10) + '&search=' + (search ? search : '') + '&orderBy=' + column + '&order=' + order;

                window.location.href = hrefString;

            });

            if (invoicesPerPage) {
                $('#numUsersPerPage').val('?invoicesPerPage=' + invoicesPerPage + '&page={{ $invoices->currentPage() }}');
            } else {
                $('#numUsersPerPage').val('?invoicesPerPage=10&page={{ $invoices->currentPage() }}');
            }
            if (search) {
                $('#search-customers').val(search);
                if (search) {
                    $('#back-button').attr('style', 'display: block').click(function () {
                        window.location.href = '/invoice-management';
                    });
                }
            }
        });


    </script>
@endsection

