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
            <h3>Employee registration</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('user.post-registration') }}">
                @csrf
                <div class="row form-group mt-3">
                    <label for="first_name" class="col-sm-4 font-weight-bold">First Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" value="{{old('first_name')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="last_name" class="col-sm-4 font-weight-bold">Last Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{old('last_name')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emp_id" class="col-sm-4 font-weight-bold">Employee ID:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emp_id" name="emp_id" placeholder="Enter Employee ID" value="{{old('emp_id')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="phone" class="col-sm-4 font-weight-bold">Phone:<span class="required">*</span></label>
                     <div class="col-sm-8">
                         <input type="text" id="phone" name="phone" placeholder="Enter Phone" value="{{old('phone')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="email" class="col-sm-4 font-weight-bold">Email:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="email" id="email" name="email" placeholder="Enter Email" value="{{old('email')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="mailing_address" class="col-sm-4 font-weight-bold">Mailing Address:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="mailing_address" name="mailing_address" placeholder="Enter Mailing Address" value="{{old('mailing_address')}}"  class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="location" class="col-sm-4 font-weight-bold">Location:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="location" name="location" class="form-control" required="required">
                            <option value="" selected> -- Select location to -- </option>
                            @foreach ($location as $id => $name)
                                <option value="{{$id}}"  > {{$name}} </option>
                            @endforeach
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="department" class="col-sm-4 font-weight-bold">Department:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="department" name="department"  class="form-control" required="required">
                            <option value="" selected> -- Select Department -- </option>
                            @foreach ($departments as $department)
                           <option value="{{$department->id}}"  > {{$department->department}} </option>
                           @endforeach
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="affiliated_to" class="col-sm-4 font-weight-bold">Affiliated to:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="affiliated_to" name="affiliated_to" class="form-control" required="required">
                            <option value="" selected> -- Select Affiliated to -- </option>
                            @foreach ($affiliated_to as $id => $name)
                                <option value="{{$id}}"  > {{$name}} </option>
                           @endforeach
                         </select>
                    </div>
                </div>

                <div class=" form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light"> Submit </button>
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
