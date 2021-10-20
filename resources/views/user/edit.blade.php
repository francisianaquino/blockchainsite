@extends('layouts.app')

@push('stylesheets')
    <link href="{{asset('vendor/select2/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container">

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="{{ action('UserController@update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Edit User</h3>
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
                <label>NFT</label>
                <select class="select2 form-control @error('is_admin') is-invalid @enderror" name="is_admin" id="is_admin">
                    <option value="1" @if($user->is_admin) selected @endif>Admin</option>
                    <option value="0" @if(!$user->is_admin) selected @endif>User</option>
                </select>
                @error('is_admin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right">
                <a class="btn btn-danger" href="{{action('UserController@index')}}" role="button">Cancel</a>
                <input type="submit" name="send" value="Submit" class="btn btn-primary">
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endpush