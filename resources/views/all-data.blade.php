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
            <h3>All Stock Data</h3>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="stock-data" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>RACK NUMBER</th>
                    <th>WEIGHT</th>
                    <th>ITEM NUMBERS</th>
                    <th>NAME</th>
                    <th>NOTE</th>
                </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        // $('#stock-data').dataTable({
        //     "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        // });
        $('#stock-data').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('stockDataTable') }}",
                "type": "GET"
            },
            "columns": [
                { "data": "id" },
                { "data": "rack_number" },
                { "data": "weight" },
                { "data": "item_number" },
                { "data": "name" },
                { "data": "note" }
            ],
            "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
        });
    </script>
@endsection
