@extends('master')

@section('style')
    <style>
        .display-none {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h2 class="text text-center">Temperature</h2>
        @if (session('info_message'))
            <div class="container alert alert-info alert-dismissible mt-5">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('info_message') }}
            </div>
        @endif
        <form class="form" method="POST" action="{{ route('temperature.store') }}">
            @csrf
            <div class="row ">
                <div class="col-12 form-group ">
                    <label for="date" class="font-weight-bold">Date <span class="required">*</span></label>
                    <input type="date" id="Date" name="Date" value="{{old('Date')}}" required="required" class="form-control">
                </div>
                <div class="col-12 form-group ">
                    <label for="name" class="font-weight-bold">Name <span class="required">*</span></label>
                    <input type="text" id="Name" name="Name" placeholder="Enter Name" value="{{old('Name')}}" required="required" class="form-control">
                </div>
                <div class="col-12 form-group ">
                    <label for="temperature" class="font-weight-bold">Temperature <span class="required">*</span></label>
                    <input type="text" id="Temperature" name="Temperature" placeholder="Enter Temperature" value="{{old('Temperature')}}" required="required" class="form-control">
                </div>
                <div class="col-12 form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light"> Submit </button>
                </div>
            </div>
        </form>
    </div>



   
@endsection

@section('script')
    <script>
    $(document).ready(function() {
    })

    </script>
@endsection
