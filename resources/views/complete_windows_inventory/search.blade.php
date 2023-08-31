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
            <h3>Complete Windows Inventory Search</h3>
        </div>
        <div class="col-4 mt-5">
            <input type="radio"  id="radio_btn" name="radio_btn" value="OrderNumber" checked/> Order Number
        </div>
        <div class="col-4 mt-5">
            <input type="radio"  id="radio_btn" name="radio_btn" value="Location" /> Location
        </div>
        <div class="col-4 mt-5">
            <input type="text"  id="search" name="search" class="form-control"/>
        </div>
        <div class="col-12 mt-5" id="table_div">
            <table class="table table-bordered" id = "search_tbl">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>CustomerName</th>
                        <th>CompanyName</th>
                        <th>Location</th>
                        <th>BatchNumber</th>
                        <th>OrderNumber</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-12" id="not_found_div">
            <div class="alert alert-danger alert-dismissible mt-5">
                Not found
            </div>
        </div>
    </div>

    
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#search").focus();

        var dataTable = $('#search_tbl').DataTable({
            "lengthMenu": [[10, 50, 100, 250, 500, -1], [10, 50, 100, 250, 500, "All"]]
        });
        $('#table_div, #not_found_div').hide()

        $("#search").keyup(function(){
            if (event.key === 'Enter') {
                var searchText = $(this).val();
                dataTable.clear();
                $('#table_div, #not_found_div').hide()

                $.ajax({
                    url: '{{ route("cwi.post_search_window") }}', 
                    method: 'POST',
                    data: { search: searchText, selected_column: $('input[name="radio_btn"]:checked').val() },
                    success: function(data) {
                        var newData = [];
                        for (var i = 0; i < data.length; i++) {
                            newData.push([
                                data[i]['Id'],
                                data[i]['Name'],
                                data[i]['CustomerName'],
                                data[i]['CompanyName'],
                                data[i]['Location'],
                                data[i]['BatchNumber'],
                                data[i]['OrderNumber'],
                                data[i]['Date'],
                            ]);
                        }
                        
                        dataTable.rows.add(newData).draw();
                        if (data.length) {
                            $('#table_div').show()
                        } else {
                            $('#not_found_div').show()
                        }
                    },
                    error: function() {
                        console.error('Error fetching data from the server.');
                    }
                });
            }
        });

        $('input[type="radio"]').change(function() {
            if  ($(this).is(':checked')) {
            $('#search').val(''); // Clear the text box
            }
        });   
    });
</script>
@endsection
