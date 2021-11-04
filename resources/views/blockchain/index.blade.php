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
    <div class="mt-5" id="container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="{{ action('BlockchainController@store') }}" method="post">
        @csrf
            <div id="blockchain_list">
                <h3>Blockchain List</h3>
                <hr>

                @foreach($blockchain as $b)
                    <div class="row my-2">
                        <div class="col-10 align-self-center">
                            <input type="text" class="form-control" value="{{ $b->cryptocurrency }}" readonly>
                        </div>
                        <div class="col-2 text-right">
                        <a class="btn btn-danger" href="{{ action('BlockchainController@destroy', ['id' => $b->id]) }}" role="button">&times</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <div class="add-blockchain">
                <div class="form-group">
                    <label>Add Blockchain</label>
                    <div class="row">
                        <div class="col-10">
                            <input type="text" class="form-control @error('cryptocurrency') is-invalid @enderror" name="cryptocurrency" id="cryptocurrency" value="{{ old('cryptocurrency') }}">
                            @error('cryptocurrency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2 align-self-center text-right">
                            <input type="submit" name="send" value="Add" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
@endpush