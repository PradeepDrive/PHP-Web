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
            <h3>Edit User</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('user.update',['user' => $edit->id]) }}">
                @csrf
                @method("PUT")

                <div class="row form-group mt-3">
                    <label for="first_name" class="col-sm-4 font-weight-bold">First Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" value="{{$edit->first_name}}" required="required" class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="last_name" class="col-sm-4 font-weight-bold">Last Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{$edit->last_name}}" required="required" class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="emp_id" class="col-sm-4 font-weight-bold">Employee ID:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emp_id" name="emp_id" placeholder="Enter Last Name" value="{{$edit->emp_id}}"  class="form-control">

                    </div>
                </div>

              

                <div class="row form-group mt-3">
                    <label for="username" class="col-sm-4 font-weight-bold">Username:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="username" name="username" placeholder="Enter Username" value="{{$edit->username}}" required="required" class="form-control">

                    </div>
                </div>
              
                <div class="row form-group mt-3">
                    <label for="password" class="col-sm-4 font-weight-bold">Password:</label>
                     <div class="col-sm-8 ">
                         <input type="password" id="password" name="password" placeholder="Enter password" value=""  class="form-control">
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="password_confirmation" class="col-sm-4 font-weight-bold">Password Confirmation:</label>
                     <div class="col-sm-8 ">
                         <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" value=""  class="form-control">
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="phone" class="col-sm-4 font-weight-bold">Phone:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="phone" name="phone" placeholder="Enter Phone" value="{{$edit->phone}}"  class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="email" class="col-sm-4 font-weight-bold">Email:</label>
                     <div class="col-sm-8 ">
                         <input type="email" id="email" name="email" placeholder="Enter email" value="{{$edit->email}}"  class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="mailing_address" class="col-sm-4 font-weight-bold">Mailing Address:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="mailing_address" name="mailing_address" placeholder="Enter Mailing Address" value="{{$edit->mailing_address}}"   class="form-control">

                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="affiliated_to" class="col-sm-4 font-weight-bold">Affiliated to:</label>
                     <div class="col-sm-8 ">
                         <select id="affiliated_to" name="affiliated_to" class="form-control" >
                            <option value="" > -- Select Affiliated to -- </option>
                            <option value="vinyl-pro" @if($edit->affiliated_to == "vinyl-pro") selected @endif > Vinyl-pro </option>
                            <option value="agency" @if($edit->affiliated_to == "agency") selected @endif > Agency </option>
                            <option value="vinyl-pro office" @if($edit->affiliated_to == "vinyl-pro office") selected @endif > Vinyl-pro Office </option>
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="department" class="col-sm-4 font-weight-bold">Department:</label>
                     <div class="col-sm-8 ">
                         <select id="department" name="department"  class="form-control" >
                            <option value="" > -- Select Department -- </option>
                           @foreach ($departments as $department)
                           <option value="{{$department->id}}" @if($department->id == $edit->department_id) selected @endif  > {{$department->department}} </option>
                           @endforeach
                           
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="access" class="col-sm-4 font-weight-bold">Pages Access:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="access" name="access[]"  value="" required="required" multiple="multiple">

                             @foreach ($pages as $page)
                             <option value="{{$page->id}}" @if(in_array($page->id, $access)) {{"selected"}} @endif > {{$page->page}} </option>
                             @endforeach
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="landing_page" class="col-sm-4 font-weight-bold">Landing Page:</label>
                     <div class="col-sm-8 ">
                         <select id="landing_page" name="landing_page"  value="" required="required" class="form-control">
                            <option value="0" @if($edit->landing_page == "0") selected @endif> home </option>
                             @foreach ($pages as $page)
                            @if($page->id != config("constant.PAGES.rack_info")) 
                            <option value="{{$page->id}}"  @if($edit->landing_page == $page->id) selected @endif > {{$page->page}} </option>
                            @endif
                             @endforeach
                         </select>
                         <span class="w-100 ml-2 small font-italic">make sure you have given this page access to the user</span>
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="remember" class="col-sm-5 font-weight-bold">Enable remember me:</label>
                     <div class="col-sm-7">
                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" {{ @$edit->remember_me ? 'checked' : '' }}>
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
