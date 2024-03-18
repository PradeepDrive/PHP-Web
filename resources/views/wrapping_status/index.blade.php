@extends('master')

@section('style')
    <style>
        .display-none {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5 display-none" id="container_div">
        <h2 class="text text-center">Wrapping status</h2>
        <div class="row">
            <div class="col-3">
                <span id="date_display"></span>
            </div>
            <!-- <div class="col-3">
                <span id="end_date_display"></span>
            </div> -->
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered" id="status_table">
                    <thead>
                        <tr>
                            <th>Order number</th>
                            <th>Assemble status</th>
                            <th>Wrapping status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="modal fade wrapping_status" id="wrapping_status" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title">Wrapping status</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group mt-3">
                        <label class="col-sm-3 text-right" for="date">Date:<span class="required">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" id="date" name="date" class="form-control date-picker" required>
                            <span class="w-100 ml-2 error display-none" id="date_error">Date must be required.!</span>
                        </div>
                    </div>
                    <!-- <div class="row form-group mt-3">
                        <label class="col-sm-3 text-right" for="end_date">End Date:<span class="required">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" id="end_date" name="end_date" class="form-control date-picker" required>
                            <span class="w-100 ml-2 error display-none" id="end_date_error">End date must be required.!</span>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="get-data" class="btn btn-info">
                       Search
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
    $(document).ready(function() {
        $('#container_div').addClass('display-none')

        $(".wrapping_status").modal("show");
        $(".date-picker").datepicker({
                dateFormat: "yy-mm-dd"
        });
    })

    $(document).on("click", "#get-data", function () {
        $('.error').addClass('display-none')
        if (!$('#date').val()) {
            $('#date_error').removeClass('display-none')
            return false;
        }

        var date = $('#date').datepicker('getDate');
        $(".wrapping_status").modal("hide");
        $('#container_div').removeClass('display-none')
        
        $('#date_display').text(`Choosed date : ${formatDate(date, "UI")}`)
        $.blockUI();
        setTimeout(() => {
            
            toLoadWrappingStatus(formatDate(date))
        }, 250);
    })


    function formatDate(date, view = false) {
        var day = date.getDate();
        var month = date.getMonth() + 1; // Month is zero-based
        var year = date.getFullYear();

        // Padding day and month with leading zeros if necessary
        day = day < 10 ? "0" + day : day;
        month = month < 10 ? "0" + month : month;

        return view == 'UI' ? day + "-" + month + "-" + year : year + "-" + month + "-" + day;
    }


    function toLoadWrappingStatus (date) {
        var search_params = { 'date': date};
        var responseData = {};

        $.ajax ({
            type: "GET",
            url: "{{ route('wrapping_status.wrappingStatusData') }}",
            async: false,
            data : search_params,
            success: function (response) {
                responseData = response;
            }
        });

        if (responseData) {
            $.each(responseData, function(ordernumber, value) {
                let rowColor = value['windows_assembly'] == 0 ? 'red' :
                    (value['windows_assembly'] == value['frame_report'] ? 'green' :
                    (value['windows_assembly'] < value['frame_report'] ? 'yellow' : ''));

                let rowColorWorkOrder = value['work_order'] == 0 ? 'red' :
                    (value['work_order'] == value['stock'] ? 'green' :
                    (value['work_order'] < value['stock'] ? 'yellow' : ''));
                
                $('#status_table tbody').append(`
                <tr>
                    <td>${ordernumber}</td>
                    <td style="background-color: ${rowColor}">${value['windows_assembly']}/${value['frame_report']}</td>
                    <td style="background-color: ${rowColorWorkOrder}">${value['work_order']}/${value['stock']}</td>
                </tr>
                `);
            });
        }

        $.unblockUI();
    }
    </script>
@endsection
