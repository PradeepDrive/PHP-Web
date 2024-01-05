@extends('layouts.app')


@section('css')

<style>
    body{
        background-color: #000000;
    }
</style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('error_message'))
<div class="alert alert-danger alert-dismissible mt-5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ session('error_message') }}
</div>
@endif







            <div class="card" style="background-color: #000000 !important; color:white; margin-top:45%" >



                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row" id="remember_div">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mb-0 col-md-6 offset-4">
                            {{-- <div class="col-md-8 offset-md-4 "> --}}
                                <button type="submit"  style="background-color: #000000; border:none; color:white;">
                                    {{ __('Login') }}
                                </button>

                            {{-- </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
      
    $(document).ready(function(){
        setTimeout(function () {
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        }, 500)
        $('#remember_div').hide()
    })

    $('#username').on('blur', function() {
        var responseData = {};
        $.ajax ({
            type: "GET",
            url: "{!! route('login.verify-remember-me') !!}",
            async: false,
            data : {'name' : $(this).val()},
            //headers: '',
            success: function (response) {
                responseData = response;
            }
        });
        $('#remember_div').show()
        if (responseData == 0) {
            $('#remember_div').hide()
        }
    })
    
    </script>
@endsection