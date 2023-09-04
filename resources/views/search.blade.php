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
    </style>
@endsection

@section('content')
    @if (session('info_message'))
        <div class="alert alert-info alert-dismissible mt-5 text-center">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('info_message') }}
        </div>
    @endif
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 mt-2" class="">
                <input type="number" class="form-control" id="search_item">
                <span class="w-100 ml-2 small error validation_error"></span>
            </div>
            <div class="col-md-6 text-center mt-2">
                <button class="btn btn-dark w-50" id="searchWindow">Search</button>
            </div>
        </div>
        <!-- Search window -->
        <div class="row mt-5 display-none heading">
            <h5 class=""><b>Search window</b></h5>
        </div>
        <form action="{{ route('upload-request') }}" method="POST">
            @csrf
            <div class="alert alert-danger mt-3 display-none" id="search_not_found">Not found</div>
            <div class="row mt-5 display-none" id="total_window">
                <table class="table-responsive border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                    <tr>
                        <td>TOTAL WINDOW</td>
                        <td v-text="total_qty"></td>
                    </tr>
                </table>
                <input type="hidden" name="item_number" id="searched_number">
                <div class="col-md-6">
                    <table class="table-responsive border-bottom mt-3" cellpadding="5" id="stock_tbl">
                    </table>
                </div>
                <div class="col-md-6 text-center mt-2">

                    <div class="form-group">

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark w-50">Unload Request</button>
                        </div>
                        <div class="stock_count font-weight-bolder text-center">
                            <span class="w-50" id="stock_data"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="dark-line display-none">
        <!-- Order number search -->
        <div class="row mt-5 display-none heading">
            <h5 class=""><b>Order search</b></h5>
        </div>
        <div class="alert alert-danger mt-3 display-none" id="order_number_not_found">Not found</div>
        <div class="row mt-5 display-none" id="order_number_div">
            <table class="table border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                <tr>
                    <td>Note:</td>
                    <td v-text="note"></td>
                </tr>
                <tr>
                    <td>Order number:</td>
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
                        html_td += `<tr>
                            <td>AISLE</td>
                            <td>${stock.aisle}</td>
                        </tr>
                        <tr>
                            <td>RACK</td>
                            <td>${stock.rack_number}</td>
                        </tr>
                        <tr>
                            <td>QTY</td>
                            <td>${stock.qty}</td>
                        </tr>`
                });
                if (searchWindowResponseData.total_available == total_qty) {
                    $('#stock_data').css({"background-color" : "#22B14C"})
                } else {
                    $('#stock_data').css({"background-color" : "#FF7F27"})
                }
                $('#stock_data').text(`${total_qty}/${searchWindowResponseData.total_available}`)
                $('#stock_tbl').html(html_td)

                $('#searched_number').val($('#search_item').val())
                $('#total_window').removeClass('display-none')
                $('#search_not_found').addClass('display-none')
            } else {
                $('#search_not_found').removeClass('display-none')
                $('#total_window').addClass('display-none')
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
           
            $('#search_item').val('')
        });

    </script>
@endsection
