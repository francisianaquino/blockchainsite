@extends('layouts.app')

@push('stylesheets')
    <style>
        #container {
            max-width: 500px;
            margin: 50px auto;
            text-align: left;
            font-family: sans-serif;
        }

        form {
            border: 1px solid #1A33FF;
            background: #ecf5fc;
            padding: 40px 50px 45px;
        }

        .form-control:focus {
            border-color: #000;
            box-shadow: none;
        }

        label {
            font-weight: 600;
        }

        .error {
            color: red;
            font-weight: 400;
            display: block;
            padding: 6px 0;
            font-size: 14px;
        }

        .form-control.error {
            border-color: red;
            padding: .375rem .75rem;
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')
    <div class="mt-5" id="container">

        @if(Session::has('success'))
            <div class="alert alert-success text-center">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="{{action('AnnouncementController@store')}}" method="post">

            @csrf

            <h3>Create Announcement</h3>
            <hr>
            <div class="form-group mb-2">
                <label>Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title">

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label>Message</label>
                <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="4"></textarea>

                @error('message')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                     
            </div>

            <div class="d-grid mt-3">
                <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
            </div>
        </form>
    </div>
@endsection

@push('scripts')
@endpush