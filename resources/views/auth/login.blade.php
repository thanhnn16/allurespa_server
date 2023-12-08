@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <p class="text-white mb-0">
                    {{ session('success') }}</p>
            </div>
        @endif
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Đăng Nhập</h4>
                                    <p class="mb-0">Nhập số điện thoại và mật khẩu để đăng nhập</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="flex flex-col mb-3">
                                            <input type="tel" name="phone_number" class="form-control form-control-lg"
                                                   placeholder="{{ old('phone_number') ?? '0123456789' }}"
                                                   aria-label="Số điện thoại">
                                            @error('phone_number') <p
                                                class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                   aria-label="Mật khẩu" placeholder="Mật khẩu">
                                            @error('password') <p
                                                class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="remember" type="checkbox"
                                                   id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Ghi nhớ</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                                Đăng nhập
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-1 text-sm mx-auto">
                                        Quên mật khẩu?
                                        <a href="https://fb.com/thanhnn0106"
                                           class="text-primary text-gradient font-weight-bold">Liên hệ</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('./img/logo.png');
              background-size: 250px; background-repeat: no-repeat; background-position: center">
                                <span class="mask opacity-4" style="background-color: #EDC06C"></span>
                                <h4 class="mt-12 text-black-50 font-weight-bolder position-relative">---</h4>
                                <p class="text-black-50 position-relative">The more effortless the writing looks, the
                                    more
                                    effort the writer actually put into the process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
