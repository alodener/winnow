@extends('site.base')
@section('content')
    <section class="position-relative h-100 pt-5 pb-4">
        <!-- Sign in form -->
        <div class="container d-flex flex-wrap justify-content-center h-100 pt-5">
            <div class="w-100 align-self-end pt-1 pt-md-4 pb-4" style="max-width: 526px;">
                <h1 class="text-center text-xl-start">Cadastro</h1>
                <p class="text-center pb-3 mb-3">Já tem uma? <a href="/login">Login</a></p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(isset($_GET['u']))
                    <?php $user = \App\Models\User::where('username', $_GET['u'])->first();?>
                    @if($user)
                        @if($user->ativo != "0")
                            <h5>Seu Consultor: {{$user->username}}</h5>
                        @endif
                    @else
                        <h5 class="text-danger">Não Existe esse Consultor!</h5>
                    @endif
                @endif
                <form method="POST" action="{{route('register')}}" class="needs-validation mb-2" novalidate>
                    @csrf
                    @if(isset($_GET['u']))
                        <?php $user = \App\Models\User::where('username', $_GET['u'])->first();?>
                        @if($user)
                            @if($user->ativo != "0")
                                <input type="hidden" name="indicacao" value="{{$user->username}}">
                            @else
                                <input type="hidden" name="indicacao" value="EduClube">
                            @endif
                        @endif
                    @else
                        <input type="hidden" name="indicacao" value="EduClube">
                    @endif

                    <div class="position-relative mb-3">

                        <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nome Completo">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <i data-feather="at-sign"></i>
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                        @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <i data-feather="at-sign"></i>
                        <input id="email-confirm" type="email" class="form-control form-control-lg"
                               name="email_confirmation" required autocomplete="off" placeholder="Confirme o Email">
                    </div>
{{--                    <div class="mb-3">--}}
{{--                        <i data-feather="smartphone"></i>--}}
{{--                        <input id="celular" type="text" class="form-control form-control-lg @error('whatsapp') is-invalid @enderror whatsapp"--}}
{{--                               name="celular" value="{{ old('celular') }}" required autocomplete="whatsapp" placeholder="whatsapp">--}}
{{--                        @error('celular')--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <div class="mb-3">--}}
{{--                        <i data-feather="user-check"></i>--}}
{{--                        <input id="cpf" type="text" class="form-control form-control-lg @error('cpf') is-invalid @enderror cpf"--}}
{{--                               name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus placeholder="CPF">--}}
{{--                        @error('cpf')--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
                    <div class="mb-3">
                        <i data-feather="user"></i>
                        <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror"
                               name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Login">
                        @error('username')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <i data-feather="lock"></i>
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password" placeholder="Senha">
                        @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <i data-feather="lock"></i>
                        <input id="password-confirm" type="password" class="form-control form-control-lg"
                               name="password_confirmation" required autocomplete="new-password" placeholder="Repita a Senha">
                    </div>
{{--                            <div class="field-wrapper terms_condition">--}}
{{--                                <div class="n-chk new-checkbox checkbox-outline-primary">--}}
{{--                                    <label class="new-control new-checkbox checkbox-outline-primary">--}}
{{--                                        <input type="checkbox" class="new-control-input" required>--}}
{{--                                        <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);">  terms and conditions </a></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                    <button type="submit" class="btn btn-primary shadow-primary btn-lg w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="/js/jquery.mask.js"></script>
    <script>
        (function( $ ) {
            $(function() {
                // $('.whatsapp').mask('(00) 0 0000-0000');
                // $('.cpf').mask('000.000.000-00', {reverse: true});
                $("#email-confirm").bind('paste', function(e) {
                    e.preventDefault();
                });
            });
        })(jQuery);
    </script>
@endpush
