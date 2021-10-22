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