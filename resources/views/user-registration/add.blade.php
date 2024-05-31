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
            <h3>Employee Registration</h3>
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
                    <label for="DateOfBirth" class="col-sm-4 font-weight-bold">Date of Birth:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="number" id="month" name="month" value="{{old('month')}}" placeholder="Month" required="required" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" id="day" name="day" value="{{old('day')}}" placeholder="Day" required="required" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" id="year" name="year" value="{{old('year')}}" placeholder="Year" required="required" class="form-control">
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row form-group mt-3">
                    <label for="mailing_address" class="col-sm-4 font-weight-bold">Address:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="mailing_address" name="mailing_address" placeholder="Enter Address" value="{{old('mailing_address')}}"  class="form-control" required="required">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="address_street_name" class="col-sm-4 font-weight-bold">Street Name:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="address_street_name" name="address_street_name" placeholder="Enter Street Name" value="{{old('address_street_name')}}"  class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="address_city" class="col-sm-4 font-weight-bold">City:<span class="required">*</span></label>
                    <div class="col-sm-8 ">
                        <input type="text" id="address_city" name="address_city" placeholder="Enter City" value="{{old('address_city')}}"  class="form-control" required="required">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="province" class="col-sm-4 font-weight-bold">Province:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="province" name="province" placeholder="Enter Province" value="{{old('province')}}"  class="form-control" required="required">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="postal_code" class="col-sm-4 font-weight-bold">Postal Code:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="postal_code" name="postal_code" placeholder="Enter Postal Code" value="{{old('postal_code')}}"  class="form-control" required="required">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="email" class="col-sm-4 font-weight-bold">Email:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="email" id="email" name="email" placeholder="Enter Email" value="{{old('email')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="phone" class="col-sm-4 font-weight-bold">Phone 1:<span class="required">*</span></label>
                     <div class="col-sm-8">
                         <input type="text" id="phone" name="phone" placeholder="Enter First Phone" value="{{old('phone')}}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="phone_2" class="col-sm-4 font-weight-bold">Phone 2:</label>
                     <div class="col-sm-8">
                         <input type="text" id="phone_2" name="phone_2" placeholder="Enter Second Phone" value="{{old('phone_2')}}" class="form-control">
                    </div>
                </div>


                <hr style="border: 1px solid #333;">



                <div class="row form-group mt-3">
                    <label for="emp_id" class="col-sm-4 font-weight-bold">Employee ID:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emp_id" name="emp_id" placeholder="Enter Employee ID" value="{{old('emp_id')}}" required="required" class="form-control">
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="affiliated_to" class="col-sm-4 font-weight-bold">Affiliated to:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="affiliated_to" name="affiliated_to" class="form-control" required="required">
                            <option value="" selected> -- Select Affiliated to -- </option>
                            @foreach ($affiliated_to as $id => $name)
                                @if (old('affiliated_to') == $id) 
                                    <option value="{{$id}}"  selected> {{$name}} </option>
                                @else
                                    <option value="{{$id}}"  > {{$name}} </option>
                                @endif
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
                                @if (old('department') == $department->id) 
                                    <option value="{{$department->id}}"  selected> {{$department->department}} </option>
                                @else
                                    <option value="{{$department->id}}"  > {{$department->department}} </option>
                                @endif
                           @endforeach
                         </select>
                    </div>
                </div>
 
                <div class="row form-group mt-3">
                    <label for="location" class="col-sm-4 font-weight-bold">Location:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="location" name="location" class="form-control" required="required">
                            <option value="" selected> -- Select location to -- </option>
                            @foreach ($location as $id => $name)
                                @if (old('location') == $id) 
                                    <option value="{{$id}}"  selected> {{$name}} </option>
                                @else
                                    <option value="{{$id}}"  > {{$name}} </option>
                                @endif
                            @endforeach
                         </select>
                    </div>
                </div>
                
                <hr style="border: 1px solid #333;">

                <div class="row form-group mt-3">
                    <label for="" class="col-sm-4 font-weight-bold">Emergency Contact # 1:</label>
                </div>

                <div class="row form-group mt-3">
                    <label for="emg_first_name_1" class="col-sm-4 font-weight-bold">First Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_first_name_1" name="emg_first_name_1" placeholder="Enter First Name" value="{{old('emg_first_name_1')}}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_last_name_1" class="col-sm-4 font-weight-bold">Last Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_last_name_1" name="emg_last_name_1" placeholder="Enter Last Name" value="{{old('emg_last_name_1')}}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="relation_to_you_1" class="col-sm-4 font-weight-bold">Relationship to You:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_relation_to_you_1" name="relation_to_you_1" placeholder="Enter Relationship to You" value="{{old('relation_to_you_1')}}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_phone_1_1" class="col-sm-4 font-weight-bold">Phone 1:<span class="required">*</span></label>
                     <div class="col-sm-8">
                         <input type="text" id="emg_phone_1_1" name="emg_phone_1_1" placeholder="Enter First Phone" value="{{old('emg_phone_1_1')}}" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_phone_1_2" class="col-sm-4 font-weight-bold">Phone 2:</label>
                     <div class="col-sm-8">
                         <input type="text" id="emg_phone_1_2" name="emg_phone_1_2" placeholder="Enter First Phone" value="{{old('emg_phone_1_2')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_email_1" class="col-sm-4 font-weight-bold">Email Address:</label>
                     <div class="col-sm-8 ">
                         <input type="email" id="emg_email_1" name="emg_email_1" placeholder="Enter Email Address" value="{{old('emg_email_1')}}" class="form-control">

                    </div>
                </div>

                <hr style="border: 1px solid #333;">

                <div class="row form-group mt-3">
                    <label for="" class="col-sm-4 font-weight-bold">Emergency Contact # 2:</label>
                </div>

                <div class="row form-group mt-3">
                    <label for="emg_first_name_2" class="col-sm-4 font-weight-bold">First Name:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_first_name_2" name="emg_first_name_2" placeholder="Enter First Name" value="{{old('emg_first_name_2')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_last_name_2" class="col-sm-4 font-weight-bold">Last Name:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_last_name_2" name="emg_last_name_2" placeholder="Enter Last Name" value="{{old('emg_last_name_2')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="relation_to_you_2" class="col-sm-4 font-weight-bold">Relationship to You:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emg_relation_to_you_2" name="relation_to_you_2" placeholder="Enter Relationship to You" value="{{old('relation_to_you_2')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_phone_2_1" class="col-sm-4 font-weight-bold">Phone 1:</label>
                     <div class="col-sm-8">
                         <input type="text" id="emg_phone_2_1" name="emg_phone_2_1" placeholder="Enter First Phone" value="{{old('emg_phone_2_1')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_phone_2_2" class="col-sm-4 font-weight-bold">Phone 2:</label>
                     <div class="col-sm-8">
                         <input type="text" id="emg_phone_2_2" name="emg_phone_2_2" placeholder="Enter First Phone" value="{{old('emg_phone_2_2')}}" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emg_email_2" class="col-sm-4 font-weight-bold">Email Address:</label>
                     <div class="col-sm-8 ">
                         <input type="email" id="emg_email_2" name="emg_email_2" placeholder="Enter Email Address" value="{{old('emg_email_2')}}" class="form-control">

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
