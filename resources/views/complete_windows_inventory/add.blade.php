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
            <h3>Complete Windows Inventory</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('cwi.add') }}">
                @csrf
                <div class="row form-group mt-3">
                    <label for="id_number" class="col-sm-4 font-weight-bold">ID number:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="id_number" name="id_number" placeholder="Enter id number" value="" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="location" class="col-sm-4 font-weight-bold">Location:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="location" name="location" placeholder="Enter location" value="{{old('location')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="b_number" class="col-sm-4 font-weight-bold">Batch number:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="batch_number" name="batch_number" placeholder="Enter batch number" value="{{old('batch_number')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="name" class="col-sm-4 font-weight-bold">Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="name" name="name" placeholder="Enter name" value="{{old('name')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="referance" class="col-sm-4 font-weight-bold">Referance:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="referance" name="referance" placeholder="Enter referance" value="{{old('referance')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class=" form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
    $("#id_number").focus();

  $('#access').multiselect({
    buttonClass:'form-control',

  });
  
//   $('#id_number').flexdatalist({
//         cache: false,
//         keywordParamName: "search_value",
//         minLength: 0,
//         searchContain: true,
//         visibleProperties: ["LINE #1"],
//         searchIn: ["LINE #1"],
//         textProperty: '{LINE #1}',
//         url: "{{ route('cwi.id_search') }}",
//         noResultsText: 'no record founded'
//     })
//     .on('select:flexdatalist', async function(event, items) {
//         // let pasient_access_log = await AJAX.AjaxHelper.POSTRequest(`${patientJournalLogUrl}?pasient_id=${items.id}`, false, false);
//         // window.location.href = '/patient/'+ items.id;
//     });
});
    </script>
@endsection
