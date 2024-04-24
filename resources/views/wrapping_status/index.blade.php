@extends('master')

@section('style')
    <style>
        .display-none {
            display: none;
        }
        .bg-danger-subtle {
            background-color: #ff8080 !important; /* Mild Red */
        }

        .bg-success-subtle {
            background-color: #d4edda !important; /* Mild Green */
            opacity: 80%;
        }

        .bg-warning-subtle {
            background-color: #ffdf80!important; /* Mild Yellow */
        }
        .text-danger {
            color: black !important; /* Dark Red */
        }

        .text-success {
            color: green !important; /* Dark Green */
        }

        .text-warning {
            color: black !important; /* Dark Yellow */
        }
        .custom-modal {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            z-index: 9999;
            margin-left:25%;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 30%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0,0,0,.2);
            border-radius: 0.3rem;
            outline: 0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: red;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .details-btn {
            background-color: lightgray;
            color: black;
            border: none;
            border: none;
            border-radius: 14px;
            padding: 11px;
            cursor: pointer;
            width: 102px;
            font-size: 16px;
        }

        .btn-deisgn {
            background-color: lightgray;
            color: black;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .row-btn {
            height: 44px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 14px;
            padding: 11px;
            cursor: pointer;
            width: 102px;
            font-size: 16px;
        }
        .no-pending-status {
            text-align: center; /* Center the text */
        }
        .font-weight {
            opacity: 100%;
            font-weight: bold;
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
                            <th class="text-center" style="font-size: large;">Order number</th>
                            <th class="text-center" style="font-size: large;">Assemble status</th>
                            <th class="text-center" style="font-size: large;">Wrapping status</th>
                            <th class="text-center" style="font-size: large;">Details</th>
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
    let rowColor = '';
    let rowTextColor = '';
    
    if (value['windows_assembly'] === 0) {
        rowColor = 'bg-danger-subtle text-danger'; // Red background
    } else if (value['windows_assembly'] === value['frame_report']) {
        rowColor = 'bg-success-subtle text-success'; // Green background
    } else if (value['windows_assembly'] < value['frame_report']) {
        rowColor = 'bg-warning-subtle text-warning'; // Yellow background
    } else {
        rowColor = 'bg-success-subtle text-success'; // Green background
    }

    let rowColorWorkOrder = '';
    
    if (value['stock'] === 0) {
        rowColorWorkOrder = 'bg-danger-subtle text-danger'; // Red background
    } else if (value['stock'] === value['work_order']) {
        rowColorWorkOrder = 'bg-success-subtle text-success'; // Green background
    } else if (value['stock'] < value['work_order']) {
        rowColorWorkOrder = 'bg-warning-subtle text-warning'; // Yellow background
    } else {
        rowColorWorkOrder = 'bg-success-subtle text-success'; // Green background
    }

    // Start appending row
    let rowHtml = `<tr>
        <td style="text-align: center;">${ordernumber}</td>
        <td class="text-center">
            <button class="btn row-btn font-weight-bold ${rowColor}">
                <p class="font-weight">${value['windows_assembly']}/${value['frame_report']}</p>
            </button>
        </td>
        <td class="text-center">
            <button class="btn row-btn font-weight-bold ${rowColorWorkOrder}">
                <p class="font-weight">${value['stock']}/${value['work_order']}</p>
            </button>
        </td>
        <td class="text-center"><button class="details-btn" data-order="${ordernumber}">Details</button></td></tr>`;

    // Append the row to the table body
    $('#status_table tbody').append(rowHtml);
});
}
function generateSpaces(count) {
    return ' '.repeat(count);
}

// Event listener for Details button
$(document).on('click', '.details-btn', function() {
    let orderNumber = $(this).data('order');
    let details = responseData[orderNumber]['pending_status'];
    
    // Construct popup content
    let popupContent = '<div class="custom-modal">';
    popupContent += '<div class="table-content">';
    popupContent += '<span class="close">&times;</span>';
    
    // Check if pending status exists
    if (details && (details.matchedRecords.length > 0 || details.unmatchedRecords.length > 0)) {
        popupContent += '<table>';
        popupContent += '<thead><tr><th>LINE #1</th><th>W.TYPE</th></tr></thead>';
        popupContent += '<tbody>';
        
        // Add matched records
        details.matchedRecords.forEach(function(record) {
            popupContent += `<tr><td class="matched-variable"><button class="btn badge row-btn p-3 bg-success-subtle" style="color: green;">${record['LINE #1']}</button></td><td class="matched-variable"><button class="btn badge row-btn p-3 bg-success-subtle" style="color: black;">${record['W_TYPE']}</button></td></tr>`;
        });
        
        // Add unmatched records
        details.unmatchedRecords.forEach(function(record) {
            popupContent += `<tr><td class="unmatched-variable"><button class="btn badge row-btn p-3 bg-danger-subtle" style="color: black;">${record['LINE #1']}</button></td><td class="unmatched-variable"><button class="btn badge row-btn p-3 bg-danger-subtle" style="color: black;">${record['W_TYPE']}</button></td></tr>`;
        });
        
        popupContent += '</tbody></table>';
    } else {
        popupContent += '<p class="no-pending-status"> No pending status </p>';
    }

    
    popupContent += '</div>';
    popupContent += '</div>';
    
    // Display custom modal with pending status details
    $('body').append(popupContent);
    
    // Close modal when close button is clicked
    $('.close').on('click', function() {
        $('.custom-modal').remove();
    });
});
        $.unblockUI();
    }
    </script>
@endsection
