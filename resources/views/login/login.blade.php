<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="theme-color" content="#4285e8">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

    <title>Login | SIPAT</title>

    @include('login.loginheader')
</head>

<body>

    <div class="login-page">

        {{-- Background Decoration --}}
        <div class="background-decoration decoration-one"></div>
        <div class="background-decoration decoration-two"></div>
        <div class="background-decoration decoration-three"></div>

        <div class="background-dot dot-one"></div>
        <div class="background-dot dot-two"></div>


        {{-- Login Card --}}
        <div class="login-card">

            {{-- =====================================================
                 LEFT : LOGIN FORM
            ====================================================== --}}
            <div class="login-form-panel">

                <div class="login-form-content">


                    {{-- =================================================
                         BRAND SIPAT
                    ================================================== --}}
                    {{-- <div class="brand">

                        <div class="brand-logo">
                            <span>S</span>
                        </div>

                        <div class="brand-info">

                            <div class="brand-name">
                                SIPAT
                            </div>

                            <div class="brand-description">
                                Sistem Informasi Pencatatan Surat
                            </div>

                        </div>

                    </div> --}}


                    {{-- =================================================
                         WELCOME
                    ================================================== --}}
                    <div class="welcome-section">

                        <h1>
                            Selamat Datang
                        </h1>

                        <p>
                            Silakan masuk untuk melanjutkan ke aplikasi
                        </p>

                    </div>


                    {{-- =================================================
                         GENERAL ERROR
                    ================================================== --}}
                    @if ($errors->any())
                        <div class="login-error">
                            {{ $errors->first() }}
                        </div>
                    @endif


                    {{-- =================================================
                         LOGIN FORM
                    ================================================== --}}
                    <form action="{{ route('authenticate') }}" method="POST">

                        @csrf


                        {{-- =================================================
                             EMAIL / USERNAME
                        ================================================== --}}
                        <div class="form-group">

                            <label for="email">
                                Username
                            </label>

                            <div class="input-box">

                                <span class="input-icon">
                                    @
                                </span>

                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="example@gmail.com" value="{{ old('email') }}" autocomplete="email"
                                    required>

                            </div>

                            @error('email')
                                <div class="validation-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================================
                             PASSWORD
                        ================================================== --}}
                        <div class="form-group">

                            <label for="password">
                                Password
                            </label>

                            <div class="input-box">

                                <span class="input-icon password-icon">
                                    •
                                </span>

                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukkan Password" autocomplete="current-password" required>

                            </div>

                            @error('password')
                                <div class="validation-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================================
                             REMEMBER + FORGOT PASSWORD
                        ================================================== --}}
                        <div class="login-options">

                            <label class="remember-control">

                                <input type="checkbox" id="ckb1" name="remember">

                                <span class="custom-checkbox"></span>

                                <span class="remember-text">
                                    Ingatkan saya
                                </span>

                            </label>


                            <a href="#" class="forgot-password">

                                Lupa Password?

                            </a>

                        </div>


                        {{-- =================================================
                             LOGIN BUTTON
                        ================================================== --}}
                        <button type="submit" class="login-button">

                            Login

                        </button>

                    </form>


                    {{-- =================================================
                         FOOTER
                    ================================================== --}}
                    <div class="form-footer">

                        SIPAT © {{ date('Y') }}

                        <span>
                            Sistem Informasi Pencatatan Surat Menyurat
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 RIGHT : IMAGE
            ====================================================== --}}
            <div class="login-image-panel">

                <img src="{{ asset('templatelogin/images/gbr_login.png') }}"
                    alt="SIPAT - Sistem Informasi Pencatatan Surat Menyurat">

            </div>

        </div>

    </div>


    @include('login.loginfooter')

</body>

</html>
