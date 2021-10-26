@extends('layouts.app')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/view.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <style>
        .image-wrap {
            position: relative;
            display: inline-block;
            overflow: hidden;
            vertical-align: middle;
        }
        .view-all {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
        }

        .view-all:before {
            display: inline-block;
            content: "";
            vertical-align: middle;
            height: 100%;
        }

        .view-all-cover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black;
            opacity: 0.4;
        }

        .view-all-text {
            position: relative;
            font-size: 16px;
            font-family: sans-serif;
            color: white;
        }



        .rating-card, .review, .review-form {
            box-shadow:0 0 5px rgba(0,0,0,.2);
            border-radius:5px;
            padding:15px;
            color:#424242
        }

        .rating-number {
            font-size: 50px !important;
        }
        .rating-number small {
            font-size: 16px;
        }



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
            font-size: 50px;
        }

        .rating-progress {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .rating-progress .rating-grade {
            padding: 3px 20px 3px 0;
            float: left;
            width: 50px;
            text-align: right;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .rating-progress .rating-grade img {
            height: 15px;
            margin-left: 3px;
        }
        .rating-progress .progress {
            float: left;
            width: calc(100% - 110px);
            border-radius: 10px;
        }
        .rating-progress .progress .bg-warning {
            background-color: #ffc107 !important;
            border-radius: 10px;
        }
        .rating-progress .rating-value {
            padding: 3px 0 3px 20px;
            float: left;
            width: 60px;
        }
        .rating-progress:after {
            content: "";
            clear: both;
            display: table;
        }



        .checked {
            color: orange;
        }



        .review-block-name{
            font-size:12px;
            margin:10px 0;
        }
        .review-block-date{
            font-size:12px;
        }
        .review-block-rate{
            font-size:13px;
            margin-bottom:15px;
        }
        .review-block-title{
            font-size:15px;
            font-weight:700;
            margin-bottom:10px;
        }
        .review-block-description{
            font-size:13px;
        }



        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            visibility: hidden;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="details">
            <div>
                <div>
                    <div class="detail">
                        <div class="row">
                            <div class="col-md-7">
                                <div>
                                    <div class="dapp_profilepic">
                                        <img loading="lazy"
                                            src="{{asset('images/game-profile/'.$game->image)}}"
                                            alt="{{$game->name}}">
                                    </div>
                                    <div class="backbutton">
                                        <a class="dropdown-item" href="{{action('GameController@index')}}"><i
                                                class="fa fa-chevron-circle-left"></i> <span>All Games</span></a>
                                    </div>

                                    <div>
                                        <div class="headline-dapp">
                                            <h1>{{$game->name}}</h1>
                                            <div class="rank_container_float"><span class="total_rank rank">#{{$game->id}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="updated">
                                        {!!$status!!}
                                    </div>
                                    <hr />
                                    <p>{{$game->description}}</p>
                                    <hr />
                                    <div class="dapp_categories">
                                        @foreach($genre as $category)
                                            <a href="#"> {{$category}} </a>
                                        @endforeach
                                    </div>
                                    <hr />
                                    <div class="dapp_platforms">
                                        @foreach($blockchain as $platform)
                                            <a data-toggle="tooltip" data-placement="top" title="{{$platform}}" href="#" data-original-title="{{$platform}}">
                                                <div class="lazy platformicon {{$platform}} loaded" data-loader="bgLoader"></div>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="dapp_devices">
                                        @foreach($device as $dev)
                                            <a data-toggle="tooltip" data-placement="top" title="{{ucfirst($dev)}}" href="#" data-original-title="{{ucfirst($dev)}}">
                                                <div class="lazy deviceimg {{ucfirst($dev)}} loaded" data-loader="bgLoader"></div>
                                            </a>
                                        @endforeach
                                    </div>
                                    <hr />
                                    <div class="dapp_nft_p2e">
                                        <div><span>NFT Support:</span>{!!$nft!!}</div>
                                        <div><span>Free-To-Play:</span>{!!$f2p!!}</div>
                                    </div>
                                    <hr />
                                    @if (isset($game->screenshots))
                                    <div class="">
                                        <div id="game-gallery" data-toggle="modal" data-target="#gameModal">
                                            @for($i = 0; $i < count($screenshots) && $i < 5; $i++)
                                                <div class="image-wrap border">
                                                    <img src="{{ asset('images/game-screenshots/'.$screenshots[$i]) }}" height="70" data-target="#gameCarousel" data-slide-to="{{$i}}">
                                                    @if($i == 4 && count($screenshots) > 5)
                                                        <div class="view-all">
                                                            <span class="view-all-cover"></span>
                                                            <span class="view-all-text">+{{count($screenshots)-$i}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- modal -->
                                        <div class="modal fade" id="gameModal" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div id="gameCarousel" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @for($i = 0; $i < count($screenshots); $i++)
                                                                <div class="carousel-item {{ $i==0 ? 'active' : '' }}">
                                                                    <img class="d-block w-100" src="{{ asset('images/game-screenshots/'.$screenshots[$i]) }}">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <a class="carousel-control-prev" href="#gameCarousel" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#gameCarousel" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-5">
                                <div class="rating-card">
                                    <div class="text-center mb-4">
                                        <h4>Rating Overview</h4>
                                        <br>
                                        <h1 class="rating-number">{{number_format(round($average_stars, 1), 1)}}<small>/5</small></h1>
                                        <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{round(($average_stars/5)*100, 2)}}%"></div>
                                        </div>
                                        <br>
                                        <span class="text-muted">{{$total_ratings}} ratings</span>
                                    </div>
                                    <div class="rating-divided">
                                        <div class="rating-progress">
                                            <span class="rating-grade">5 <i class="fa fa-star" aria-hidden="true"></i></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total_ratings > 0 ? ($ratings['5_stars']/$total_ratings)*100 : 0}}%" aria-valuenow="{{$total_ratings > 0 ? ($ratings['5_stars']/$total_ratings)*100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-value">{{$ratings['5_stars']}}</span>
                                        </div>
                                        <div class="rating-progress">
                                            <span class="rating-grade">4 <i class="fa fa-star" aria-hidden="true"></i></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total_ratings > 0 ? ($ratings['4_stars']/$total_ratings)*100 : 0}}%" aria-valuenow="{{$total_ratings > 0 ? ($ratings['4_stars']/$total_ratings)*100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-value">{{$ratings['4_stars']}}</span>
                                        </div>
                                        <div class="rating-progress">
                                            <span class="rating-grade">3 <i class="fa fa-star" aria-hidden="true"></i></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total_ratings > 0 ? ($ratings['3_stars']/$total_ratings)*100 : 0}}%" aria-valuenow="{{$total_ratings > 0 ? ($ratings['3_stars']/$total_ratings)*100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-value">{{$ratings['3_stars']}}</span>
                                        </div>
                                        <div class="rating-progress">
                                            <span class="rating-grade">2 <i class="fa fa-star" aria-hidden="true"></i></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total_ratings > 0 ? ($ratings['2_stars']/$total_ratings)*100 : 0}}%" aria-valuenow="{{$total_ratings > 0 ? ($ratings['2_stars']/$total_ratings)*100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-value">{{$ratings['2_stars']}}</span>
                                        </div>
                                        <div class="rating-progress">
                                            <span class="rating-grade">1 <i class="fa fa-star" aria-hidden="true"></i></span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total_ratings > 0 ? ($ratings['1_stars']/$total_ratings)*100 : 0}}%" aria-valuenow="{{$total_ratings > 0 ? ($ratings['1_stars']/$total_ratings)*100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-value">{{$ratings['1_stars']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr />

                        <div class="">
                            <h4>Game Reviews</h4>
                            <hr />
                            <div class="container">
                                @foreach($game->reviews as $review)
                                <div class="review row">
                                    <div class="col-sm-3 col-md-2">
                                        <img src="{{ asset('images/user-profile/'.$review->user->image) }}" class="rounded-circle" width="80">
                                        <div class="review-block-name"><a href="#">{{$review->user->name}}</a></div>
                                        <div class="review-block-date">{{$review->created_at->format("F j, Y, g:i a")}}</div>
                                    </div>
                                    <div class="col">
                                        <div class="review-block-rate">
                                        <span class="text-muted">{{$review->rating}}</span>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{($i <= $review->rating) ? 'checked' : '' }}" aria-hidden="true"></i>
                                            @endfor
                                        </div>
                                        <div class="review-block-title">{{$review->subject}}</div>
                                        <div class="review-block-description">{{$review->description}}</div>
                                    </div>
                                    @if (isset($review->screenshots))
                                    <div class="col my-auto">
                                        <div class="text-right" id="{{ 'review'.$review->id }}" data-toggle="modal" data-target="{{ '#reviewModal'.$review->id }}">
                                            @for($i = 0; $i < count($img = explode(',', $review->screenshots)) && $i < 4; $i++)
                                                <div class="image-wrap border">
                                                    <img src="{{ asset('images/review-screenshots/'.$img[$i]) }}" height="70" data-target="{{ '#reviewCarousel'.$review->id }}" data-slide-to="{{$i}}">
                                                    @if($i == 3 && count($img) > 4)
                                                        <div class="view-all">
                                                            <span class="view-all-cover"></span>
                                                            <span class="view-all-text">+{{count($img)-$i}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- modal -->
                                        <div class="modal fade" id="{{ 'reviewModal'.$review->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div id="{{ 'reviewCarousel'.$review->id }}" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @for($i = 0; $i < count($img); $i++)
                                                                <div class="carousel-item {{ $i==0 ? 'active' : '' }}">
                                                                    <img class="d-block w-100" src="{{ asset('images/review-screenshots/'.$img[$i]) }}">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <a class="carousel-control-prev" href="{{ '#reviewCarousel'.$review->id }}" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="{{ '#reviewCarousel'.$review->id }}" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <hr />
                                @endforeach
                            </div>
                        </div>

                        <div class="review-form">
                            <h5 class="mb-4">Leave Review</h5>
                            <form action="{{action('ReviewController@store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="game_id" value="{{$game->id}}">
                                <div class="d-flex align-items-center">
                                    <label class="mb-2">Game Rating:</label>
                                    <div class="rate form-group">
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                        @error('rating')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject" value="{{ old('subject') }}">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{ old('description') }}" rows="4"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Attach Screenshots</label>
                                    <input type="file" class="form-control @error('screenshots') is-invalid @enderror" name="screenshots[]" id="screenshots" multiple="multiple">
                                    @error('screenshots')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-right">
                                    <input type="submit" name="send" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tooltip-large"]').tooltip({
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
            });
        });
    </script>
@endpush