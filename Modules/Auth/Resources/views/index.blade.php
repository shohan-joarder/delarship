@extends('layouts.auth')

@section('content')
<div>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <!-- Login basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{url('/')}}" class="brand-logo">
                                    <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                        <defs>
                                            <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                                <stop stop-color="#000000" offset="0%"></stop>
                                                <stop stop-color="#FFFFFF" offset="100%"></stop>
                                            </lineargradient>
                                            <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                                <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                                <stop stop-color="#FFFFFF" offset="100%"></stop>
                                            </lineargradient>
                                        </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                                <g id="Group" transform="translate(400.000000, 178.000000)">
                                                    <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                                    <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                                    <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                                    <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                                    <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <h2 class="brand-text text-primary ms-1">Vuexy</h2>
                                </a>

                                <h4 class="card-title mb-1">Welcome to {{env("APP_NAME")}}! 👋</h4>
                                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>

                                <span class="errorFlash text-center">

                                </span>


                                <form class="auth-login-form mt-2" method="POST" action="{{route('login')}}" id="loginForm">
                                    @csrf
                                    <div class="mb-1">
                                        <label for="login-email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="login-email" name="email"
                                         placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus
                                         wire:model='data.email'
                                         />
                                         <span class="text-danger text-xs errors error_email"></span>
                                    </div>

                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Password</label>
                                            {{-- <a href="auth-forgot-password-basic.html">
                                                <small>Forgot Password?</small>
                                            </a> --}}
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2"
                                             placeholder="Password" aria-describedby="login-password"
                                             wire:model='data.password'
                                             />
                                            <span class="input-group-text cursor-pointer showPass" ><i class="fa-solid fa-eye-slash"></i></span>
                                        </div>
                                       <div class="text-danger text-xs errors error_password"></div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me </label>
                                        </div>
                                    </div>
                                    <div class="submitButton">
                                        <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                                    </div>
                                </form>

                                <p class="text-center mt-2">
                                    <span>New on our platform?</span>
                                    <a href="{{route('register')}}">
                                        <span>Create an account</span>
                                    </a>
                                </p>

                                {{-- <div class="divider my-2">
                                    <div class="divider-text">or</div>
                                </div>

                                <div class="auth-footer-btn d-flex justify-content-center">
                                    <a href="#" class="btn btn-facebook">
                                        <i data-feather="facebook"></i>
                                    </a>
                                    <a href="#" class="btn btn-twitter white">
                                        <i data-feather="twitter"></i>
                                    </a>
                                    <a href="#" class="btn btn-google">
                                        <i data-feather="mail"></i>
                                    </a>
                                    <a href="#" class="btn btn-github">
                                        <i data-feather="github"></i>
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function () {

        let lodingButton = '<button class="btn btn-primary w-100" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="">Loading...</span></button>';

        let showPassword = false;
        $(document).on("click",".showPass",function(){
            showPassword = !showPassword;
            if(showPassword == false){
                $("#login-password").attr('type', 'password');
                $(".fa-solid").addClass('fa-eye-slash')
                $(".fa-solid").removeClass('fa-eye')
            }else{
                $("#login-password").attr('type', 'text')
                $(".fa-solid").removeClass('fa-eye-slash')
                $(".fa-solid").addClass('fa-eye')
            }
        });

        $(document).on("submit", "#loginForm",function(e){
            e.preventDefault();
            let submitButton = $(".submitButton").html();
            $(".errors, .errorFlash").html('');
            $.ajax({
                url : $(this).attr("action"),
                type : 'POST',
                data : $("#loginForm").serialize(),
                beforeSend : function(){
                    $(".submitButton").html(lodingButton);
                },
                success : function(response){
                    const {status, message,errors} = response;
                    if(status == false){
                        if(message){$('.errorFlash').html(`<span class="alert alert-danger errorMsg" role="alert">${message}</span>`)}
                        if(errors){
                            let errorsArr = Object.entries(errors);
                            for (let index = 0; index < errorsArr.length; index++) {
                                $(".error_"+errorsArr[index][0]).html(errorsArr[index][1][0]);
                            }
                        }
                    }
                    if(status == true){
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: `${message}`,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>location.reload())

                    }
                },
                complete : function(data){
                    $( ".submitButton" ).html(submitButton);
                }
            });
        });

    });


</script>

@endpush
