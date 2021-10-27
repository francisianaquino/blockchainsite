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

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="{{ action('ProfileController@update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/user-profile/'.$user->image) }}" class="rounded-circle" width="90">
                <h3 class="ml-3">{{ $user->name }}</h3>
            </div>
            <hr>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email }}" readonly>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right">
                <a class="btn btn-danger" href="{{action('GameController@index')}}" role="button">Cancel</a>
                <input type="submit" name="send" value="Submit" class="btn btn-primary">
            </div>
        </form>
        <hr class="mb-5">

        <h3>Games You Added</h3>
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
                ajax: "{{ action('ProfileController@index') }}",
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