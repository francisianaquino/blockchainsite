@extends('layouts.app')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <style>
        .ratings {
            position: relative;
            vertical-align: middle;
            display: inline-block;
            color: #b1b1b1;
            overflow: hidden;
        }
        .full-stars {
            position: absolute;
            left: 0;
            top: 0;
            white-space: nowrap;
            overflow: hidden;
            color: orange;
        }
        .empty-stars:before, .full-stars:before {
            content:"\2605\2605\2605\2605\2605";
            font-size: 20px;
        }
        .average {
            vertical-align: middle;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="list_h1">
            <h1>Top 50 Blockchain Games List</h1>
        </div>

        <table class="table table-bordered data-table mainlist indexmaintable">
            <thead class="header">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Genre</th>
                    <th>Blockchain</th>
                    <th>Device</th>
                    <th>Status</th>
                    <th>NFT</th>
                    <th>F2P</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>


    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ action('GameController@pending') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'genre', name: 'genre'},
                    {data: 'blockchain', name: 'blockchain'},
                    {data: 'device', name: 'device'},
                    {data: 'status', name: 'status'},
                    {data: 'nft', name: 'nft'},
                    {data: 'f2p', name: 'f2p'},
                    {data: 'rating', name: 'rating'},
                    {data: 'action', name: 'action'},
                ],
                "paging":   false,
                "ordering": false,
                "info":     false
            });

            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tooltip-large"]').tooltip({
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
            });
        });
    </script>
@endpush