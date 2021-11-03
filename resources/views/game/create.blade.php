@extends('layouts.app')

@push('stylesheets')
    <link href="{{asset('vendor/select2/css/select2.min.css')}}" rel="stylesheet" />
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

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        <form action="{{ action('GameController@store') }}" method="post" enctype="multipart/form-data">

            <!-- CROSS Site Request Forgery Protection -->
            @csrf

            <h3>Add Game</h3>
            <hr>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{ old('description') }}">
                @error('description')
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

            <div class="form-group">
                <label>Genre</label>
                <select class="select2 form-control @error('genre') is-invalid @enderror" name="genre[]" id="genre" multiple="multiple">
                    @foreach($genre as $g)
                        <option value="{{$g->genre}}">{{strtoupper($g->genre)}}</option>
                    @endforeach
                </select>
                @error('genre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Blockchain</label>
                <select class="select2 form-control @error('blockchain') is-invalid @enderror" name="blockchain[]" id="blockchain" multiple="multiple">
                    <option value="Ethereum">Ethereum</option>
                    <option value="Enjin">Enjin</option>
                    <option value="Bitcoin">Bitcoin</option>
                    <option value="Polygon">Polygon</option>
                    <option value="Binance">Binance</option>
                    <option value="Solana">Solana</option>
                    <option value="Cardano">Cardano</option>
                    <option value="Immutable-X">Immutable-X</option>
                    <option value="WAX">WAX</option>
                    <option value="Avalanche">Avalanche</option>
                    <option value="EOS">EOS</option>
                    <option value="TRON">TRON</option>
                    <option value="Hive">Hive</option>
                    <option value="Flow">Flow</option>
                    <option value="VeChain">VeChain</option>
                    <option value="Phantasma-Chain">Phantasma-Chain</option>
                    <option value="KardiaChain">KardiaChain</option>
                    <option value="Ronin">Ronin</option>
                    <option value="NEO">NEO</option>
                    <option value="ZENZO">ZENZO</option>
                    <option value="POA">POA</option>
                    <option value="Chain-Games">Chain-Games</option>
                    <option value="Steem">Steem</option>
                    <option value="Waves">Waves</option>
                    <option value="Nebulas">Nebulas</option>
                    <option value="Litecoin">Litecoin</option>
                    <option value="BSV">BSV</option>
                    <option value="Klaytn">Klaytn</option>
                    <option value="Polkadot">Polkadot</option>
                    <option value="IOST">IOST</option>
                    <option value="Loom">Loom</option>
                    <option value="Other">Other</option>
                </select>
                @error('blockchain')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Device</label>
                <select class="select2 form-control @error('device') is-invalid @enderror" name="device[]" id="device" multiple="multiple">
                    <option value="Web">Web</option>
                    <option value="Android">Android</option>
                    <option value="IOS">IOS</option>
                    <option value="Windows">Windows</option>
                    <option value="MAC">MAC</option>
                    <option value="Linux">Linux</option>
                    <option value="Playstation">Playstation</option>
                    <option value="XBOX">XBOX</option>
                    <option value="Nintendo">Nintendo</option>
                </select>
                @error('device')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="select2 form-control @error('status') is-invalid @enderror" name="status" id="status">
                    <option value="Live">Live</option>
                    <option value="Presale">Presale</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Beta">Beta</option>
                    <option value="Development">Development</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
            </div>

            <div class="form-group">
                <label>NFT</label>
                <select class="select2 form-control @error('nft') is-invalid @enderror" name="nft" id="nft">
                    <option value="1">NFT Support</option>
                    <option value="0">No NFT Support</option>
                </select>
                @error('nft')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>F2P</label>
                <select class="select2 form-control @error('f2p') is-invalid @enderror" name="f2p" id="f2p">
                    <option value="Free-To-Play">Free-To-Play</option>
                    <option value="NFT Required">NFT Required</option>
                    <option value="Crypto Required">Crypto Required</option>
                    <option value="Game Required">Game Required</option>
                </select>
                @error('f2p')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Game Screenshots</label>
                <input type="file" class="form-control @error('screenshots') is-invalid @enderror" name="screenshots[]" id="screenshots" multiple="multiple">
                @error('screenshots')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right mt-4">
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