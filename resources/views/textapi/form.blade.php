@extends('master')

@section('content')
<div class="container my-5">
    @if (session('info_message'))
        <div class="alert alert-info alert-dismissible mt-5">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('info_message') }}
        </div>
    @endif
    @if (session('error_message'))
        <div class="alert alert-danger alert-dismissible mt-5">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('error_message') }}
        </div>
    @endif
    <div class="row mt-5">
        <div class="col-12">
            <h3>TextAPI Configuration</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('text-api.store') }}">
                @csrf
                <div class="row form-group mt-3">
                    <label for="text_url_label" class="col-sm-4 font-weight-bold">Text URL :<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="text_url" name="text_url" placeholder="Enter text url" value="{{    @$sms->text_url ? $sms->text_url : old('text_url') }}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="token_label" class="col-sm-4 font-weight-bold">Token :<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="token" name="token" placeholder="Enter Token" value="{{    @$sms->token ? @$sms->token : old('token') }}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="from_label" class="col-sm-4 font-weight-bold">From Number :<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" name="code_number" value="+1" disabled="disabled" class="form-control"/>
                            </div>
                            <div class="col-10">
                                <input type="number" id="from" name="from" placeholder="Enter From Number" value="{{ @$sms->from ? @$sms->from : old('from') }}" required="required" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="message_label" class="col-sm-4 font-weight-bold">Text URL :<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <textarea id="message" name="message" placeholder="Enter Message" required="required" class="form-control" rows="4" cols="50">{{ @$sms->message ? @$sms->message : old('message') }}</textarea>
                    </div>
                </div>
                <div class=" form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light"> Submit </button>
                    <a href="{{ route('text-api.destory') }}" class="btn btn-danger text-light">Clear</a>
                    <a href="{{ route('settings') }}" class="btn btn-primary text-light">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
  $('#access').multiselect({
    buttonClass:'form-control',

  });
});
    </script>
@endsection
