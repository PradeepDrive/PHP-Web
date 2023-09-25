@extends('master')

@section('style')
    <style>
        .stock_count span {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 30px;
            display: inline-block;
            margin-top: 20px;
        }
        .display-none {
            display: none;
        }
        hr.dark-line {
            border: none; /* Remove the default border */
            height: 2px;   /* Set the height of the line */
            background-color: #000; /* Set the background color to black (or any dark color you prefer) */
        }
        .bottomdiv {
            position:absolute; 
            bottom:0;
        }
    </style>
@endsection

@section('content')
    @if (session('info_message'))
        <div class="alert alert-info alert-dismissible mt-5 text-center">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('info_message') }}
        </div>
    @endif
    <div class="my-5">
        <div class="row">
            <div class="col-md-3 text-bottom">
            </div>
            <div class="col-md-3 mt-2">
                <input type="number" class="form-control" id="search_item">
                <span class="w-100 ml-2 small error validation_error"></span>
            </div>
            <div class="col-md-3 text-center mt-2">
                <button class="btn btn-dark" id="searchWindow">Search</button>
            </div>
            <div class="col-md-3 text-center total_window display-none">
                <form action="{{ route('upload-request') }}" method="POST" id="upload-request-form">
                @csrf
                    <input type="hidden" name="item_number" id="searched_number">
                    <input type="hidden" name="shipper_id" id="shipper_id">

                    <div class="form-group">
                        <div class="form-group">
                            <button type="button" class="btn btn-dark w-50" id="upload-request-btn">Unload Request</button>
                        </div>
                    </div>
            </div>
            <div class="col-md-9 display-none total_window">
                <div class="col-md-1"></div>
                <div class=" col-md-11 bottomdiv">
                    <b>TOTAL WINDOWS : <span id="total_qty"></span></b>
                </div>
            </div>
            <div class="col-md-3 display-none total_window">
                    <div class="stock_count font-weight-bolder text-center">
                        <span class="w-50" id="stock_data"></span>
                    </div>
                </form>
            </div>
        </div>
        <!-- Search window -->
        <div class="row display-none" id="search_not_found">
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <b>TOTAL WINDOWS</b>
                </div>
            </div>
            <div class="col-12">
                <div class="alert alert-danger mt-3">Not found</div>
            </div>
        </div>
        <div class="row mt-1 display-none total_window">
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-12">
                    <div class="row" id="stock_tbl"></div>
                </div>
            </div>
        </div>

        <hr class="dark-line display-none">

        <!-- Order number search -->
        <div class="row">
            <div class="col-6">
                <div class="row display-none" id="order_number_not_found">
                    <div class="col-md-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Note</b>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-danger mt-3">Not found</div>
                    </div>
                </div>
                <div class="row mt-5 display-none" id="order_number_div">
                    <div class="col-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <table class="table border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                                <tr>
                                    <td colspan="8">Note:</td>
                                    <td v-text="note"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Order number:</td>
                                    <td id="order_number_td"></td>
                                    <td></td>
                                    <td>Company Name:</td>
                                    <td id="company_name_td"></td>
                                    <td></td>
                                    <td>Customer PO:</td>
                                    <td id="customer_po_td"></td>
                                </tr>
                            </table>
                            <input type="hidden" name="order_number" v-model="searched_number">
                            <div class="col-md-12">
                                <table class="table table-bordered border-bottom mt-3" cellpadding="5" id="order_tbl">
                                    <thead>
                                        <tr>
                                            <th>Item number</th>
                                            <th>Window Description</th>
                                            <th>Location</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Wrapper ID</th>
                                            <th>Shipped</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row display-none" id="glass_report_not_found">
                    <div class="col-md-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Window Assembly</b>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-danger mt-3">Not found</div>
                    </div>
                </div>
                <div class="row mt-5 display-none" id="glass_report_div">
                    <div class="col-12">
                        <!-- <div class="col-md-1"></div> -->
                        <div class="col-md-12">
                            <table class="table border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                                <tr>
                                    <td colspan="10">Window Assembly</td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <td colspan="10">Recut note:</td>
                                    <td id="window_assembly_data" class="text-danger"></td>
                                    <td colspan="5"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered border-bottom mt-3" cellpadding="5" style="font-weight: bold;" id="glass_report_tbl">
                                <thead>
                                    <tr>
                                        <td>LINE #1</td>
                                        <td>QTY</td>
                                        <td>WIDTH</td>
                                        <td>HEIGHT</td>
                                        <td>W.TYPE</td>
                                        <td>SCAN QUANTITY</td>
                                        <td>DATE</td>
                                        <td>TIME</td>
                                        <td>NAME</td>
                                        <td>STATUS</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="contacts_list" id="contacts_list" value="{{ @$contacts_list }}">
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#search_item").focus();
        });
        $('#search_item').keypress(function(event) {
            if (event.which === 13 || event.key === 'Enter') {
                $('#searchWindow').trigger('click')            }
        });
        $('#searchWindow').click(function(event) {
            event.preventDefault();
            $('.validation_error').text('')
            if (!$('#search_item').val()) {
                $('.validation_error').text('Please input item number')
                return;
            }
            $('.heading, .dark-line').removeClass('display-none')
            //Search window
            var search_window_param = { item_number: $('#search_item').val() };
            
            var searchWindowResponseData = {};
            $.ajax({
                url: "{{ route('search-window') }}",
                data: search_window_param,
                type: "POST",
                async: false,
                success: function (dataval) {
                    searchWindowResponseData = dataval;
                },
                error: function (response) {
                    searchWindowResponseData = 111
                },
                failure: function (response) {
                }
            });

            if (searchWindowResponseData.stocks.length > 0) {

                var total_qty = 0;
                var html_td = ''
                searchWindowResponseData.stocks.forEach(function(stock) {
                        total_qty += stock.qty;
                        html_td += `<div class="col-2 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <p><b>AISLE ${stock.aisle}</b></p>
                                    <p><b>RACK ${stock.rack_number}</b></p>
                                    <p class="float-right"><b>QTY ${stock.qty}</b></p>
                                </div>
                            </div>
                        </div>`
                });
                if (searchWindowResponseData.total_available == total_qty) {
                    $('#stock_data').css({"background-color" : "#22B14C"})
                } else {
                    $('#stock_data').css({"background-color" : "#FF7F27"})
                }
                $('#total_qty').html(total_qty)
                $('#stock_data').text(`${total_qty}/${searchWindowResponseData.total_available}`)
                $('#stock_tbl').html(html_td)

                $('#searched_number').val($('#search_item').val())
                $('.total_window').removeClass('display-none')
                $('#search_not_found').addClass('display-none')
            } else {
                $('#search_not_found').removeClass('display-none')
                $('.total_window').addClass('display-none')
            }


            //Order-search
            var order_search_param = { order_number: $('#search_item').val() };
            
            var orderSearchResponseData = {};
            $.ajax({
                url: "{{ route('order-search') }}",
                data: order_search_param,
                type: "POST",
                async: false,
                success: function (dataval) {
                    orderSearchResponseData = dataval;
                },
                error: function (response) {
                    orderSearchResponseData = 111
                },
                failure: function (response) {
                }
            });
            
            if (orderSearchResponseData.orders.length > 0) {
                $('#order_number_td').text($('#search_item').val())
                $('#company_name_td').text(orderSearchResponseData.match.DEALER)
                $('#customer_po_td').text(orderSearchResponseData.match.PO)

                var table_data = orderSearchResponseData.orders.map((order => {
                                order['line'] = order['LINE #1'];
                                order['window'] = order['WINDOW DESCRIPTION'];
                                if (order['created_at']) {
                                    let fields1 = order['created_at'].split(' ');
                                    order['date'] = fields1[0];
                                    order['time'] = fields1[1];
                                }
                                if (order['wrapper']) {
                                    let fields2 = order['wrapper'].split('(');
                                    order['wrapper'] = fields2[0];
                                }
                                return order;
                            }));
                var table_tr = ''
                table_data.forEach(stock => {
                    table_tr += `<tr>
                                <td>${stock.line ? stock.line : ''}</td>
                                <td>${stock.window ? stock.window : ''}</td>
                                <td style="background:${stock.location == 'No' ? "red" : "green"};"> ${stock.location ? stock.location : ''}</td>
                                <td>${stock.date ? stock.date : ''}</td>
                                <td>${stock.time ? stock.time : ''}</td>
                                <td>${stock.wrapper ? stock.wrapper : ''}</td>
                                <td class="text-success">${stock.shipped ? stock.shipped : ''}</td>
                            </tr>`
                });
                $('#order_tbl tbody').html(table_tr)
                $('#order_number_not_found').addClass('display-none')
                $('#order_number_div').removeClass('display-none')
            } else {
                $('#order_number_not_found').removeClass('display-none')
                $('#order_number_div').addClass('display-none')
            }
           

            //Glass-report
            var glass_search_param = { order_number: $('#search_item').val() };
            var glassResponseData = {};

            $.ajax ({
                type: "GET",
                url: "{{ route('glass.report') }}",
                async: false,
                data : glass_search_param,
                success: function (response) {
                    glassResponseData = response;
                }
            });
            if (glassResponseData.data.length > 0) {
                var table_tr = ''
                glassResponseData.data.forEach(glassReports => {
                    var original_date = glassReports.date ? glassReports.date.split("-") : ''
                    var date = original_date[2]+'-'+original_date[1]+'-'+original_date[0]
                    table_tr += `<tr>
                                <td>${glassReports.line1 ? glassReports.line1 : ''}</td>
                                <td>${glassReports.qty ? glassReports.qty : ''}</td>
                                <td>${glassReports.width ? glassReports.width : ''}</td>
                                <td>${glassReports.height ? glassReports.height : ''}</td>
                                <td>${glassReports.window_type ? glassReports.window_type : ''}</td>
                                <td>${glassReports.scan_qty ? glassReports.scan_qty : ''}</td>
                                <td>${date ? date : ''}</td>
                                <td>${glassReports.time ? glassReports.time.split(".")[0] : ''}</td>
                                <td>${glassReports.name ? glassReports.name : ''}</td>
                                <td style="background:${glassReports.color};">${glassReports.status ? glassReports.status : ''}</td>
                            </tr>`
                });
                $('#glass_report_tbl tbody').html(table_tr)

                $('#glass_report_div').removeClass('display-none')
                $('#glass_report_not_found').addClass('display-none')
            } else {
                $('#glass_report_not_found').removeClass('display-none')
                $('#glass_report_div').addClass('display-none')
            }
            var window_assembly_data = ''
            if (glassResponseData.additional_data.GlassRecut) {
                var data = glassResponseData.additional_data.GlassRecut
                window_assembly_data += `Frame: ${data.Date} ${data.Reason}/${data.Name}` 
            }

            if (glassResponseData.additional_data.FrameRecut) {
                var data = glassResponseData.additional_data.FrameRecut
                window_assembly_data += " ";
                window_assembly_data += `Glass: ${data.Date} ${data.Reason}/${data.Name}` 
            }
            $('#window_assembly_data').html(window_assembly_data)
            $('#search_item').val('')
        });

        $('#upload-request-btn').click(async function(event) {
            var contacts = $('#contacts_list').val()
            const { value: user } = await Swal.fire({
                title: 'Select User',
                input: 'select',
                inputOptions: JSON.parse(contacts),
                inputPlaceholder: '----Select----',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                    if (value) {
                        resolve()
                    } else {
                        resolve('You need to choose the user :)')
                    }
                    })
                }
            })

            if (user) {
                $('#shipper_id').val(user)
                $('#upload-request-form').submit()
            }
        })
    </script>
@endsection

