@extends('layouts.app')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
@endpush

@section('content')
    <div class="container">

        <table class="table table-bordered data-table">
            <thead class="header">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Verified At</th>
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
                ajax: "{{ action('UserController@index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'is_admin', name: 'is_admin'},
                    {data: 'email_verified_at', name: 'email_verified_at'},
                    {data: 'action', name: 'action'}
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