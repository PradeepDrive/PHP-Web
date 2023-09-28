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
            <h3>Edit Contact</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('contacts.update',['contact' => $edit->id]) }}">
                @csrf
                @method("PUT")

                <div class="row form-group mt-3">
                    <label for="department" class="col-sm-4 font-weight-bold">Name :<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="name" name="name" placeholder="Enter Contact Name" value="{{$edit->name}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="phone_number" class="col-sm-4 font-weight-bold">Phone number:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" name="code_number" value="+1" disabled="disabled" class="form-control"/>
                            </div>
                            <div class="col-10">
                                <input type="text" id="phone_number" name="phone_number" placeholder="Enter Contact Phone Number" value="{{$edit->phone_number}}" required="required" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class=" form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light"> Submit </button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-primary text-light">BACK</a>
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
