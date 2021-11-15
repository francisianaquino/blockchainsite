<?php

namespace App\Http\Controllers;
use App\Game;
use Auth;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class MyGamesController extends Controller
{
    public function index() {
        $user = Auth::user();

        $games = Game::where('user_id', $user->id);

        if (request()->ajax()) {
            return Datatables::of($games)
                ->editColumn('name', function(Game $game) {
                    return '<a href="'.action('GameController@show', ['id' => $game->id]).'" class="dapp_detaillink">
                                <div class="dapp_detaillink">
                                    <div class="dapp_profilepic dapp_profilepic_list">
                                        <img loading="lazy"
                                        src="'.asset('images/game-profile/'.$game->image).'"
                                        alt="'.$game->name.'">
                                    </div>
                                    <div class="dapp_name">
                                        <span>'.$game->name.'</span>
                                        <span>'.$game->description.'</span>
                                    </div>
                                </div>
                            </a>';
                })
                ->editColumn('genre', function(Game $game) {
                    $genre = explode(',', $game->genre);
                    $html = '';
                    foreach ($genre as $g) {
                        $html .= '<a href="#">'.strtoupper($g).'</a>';
                    }
                    return $html;
                })
                ->editColumn('blockchain', function(Game $game) {
                    $blockchain = explode(',', $game->blockchain);
                    $html = '';
                    foreach ($blockchain as $b) {
                        $html .= '<a data-toggle="tooltip" data-placement="top" title="'.$b.'" href="#" data-original-title="'.$b.'">
                                    <div class="lazy platformicon '.$b.' loaded" data-loader="bgLoader"></div>
                                </a>';
                    }
                    return $html;
                })
                ->editColumn('device', function(Game $game) {
                    $device = explode(',', $game->device);
                    $html = '';
                    foreach ($device as $d) {
                        $html .= '<a data-toggle="tooltip" data-placement="top" title="'.ucfirst($d).'" href="#" data-original-title="'.ucfirst($d).'">
                                    <div class="lazy deviceimg '.ucfirst($d).' loaded" data-loader="bgLoader"></div>
                                </a>';
                    }
                    return $html;
                })
                ->editColumn('status', function(Game $game) {
                    $html = '';
                    if (ucfirst($game->status) == 'Live') {
                        $html = '<a href="#" style="color: #5cd958;border: 1px solid #5cd958" 
                                    data-toggle="tooltip" data-placement="top" title="Live" data-original-title="Live">
                                    Live
                                </a>';
                    }
                    else if (ucfirst($game->status) == 'Presale') {
                        $html = '<a href="#" style="color: #c60c0c;border: 1px solid #c60c0c" 
                                    data-toggle="tooltip" data-placement="top" title="Presale" data-original-title="Presale">
                                    Presale
                                </a>';
                    }
                    else if (ucfirst($game->status) == 'Alpha') {
                        $html = '<a href="#" style="color: #1188ff;border: 1px solid #1188ff" 
                                    data-toggle="tooltip" data-placement="top" title="Alpha" data-original-title="Alpha">
                                    Alpha
                                </a>';
                    }
                    else if (ucfirst($game->status) == 'Beta') {
                        $html = '<a href="#" style="color: #ffb700;border: 1px solid #ffb700" 
                                    data-toggle="tooltip" data-placement="top" title="Beta" data-original-title="Beta">
                                    Beta
                                </a>';
                    }
                    else if (ucfirst($game->status) == 'Development') {
                        $html = '<a href="#" style="color: #4700ff;border: 1px solid #4700ff" 
                                    data-toggle="tooltip" data-placement="top" title="Development" data-original-title="Development">
                                    Development
                                </a>';
                    }
                    else if (ucfirst($game->status) == 'Cancelled') {
                        $html = '<a href="#" style="color: #9a9a9a;border: 1px solid #9a9a9a" 
                                    data-toggle="tooltip" data-placement="top" title="Cancelled" data-original-title="Cancelled">
                                    Cancelled
                                </a>';
                    }
                    return $html;
                })
                ->editColumn('nft', function(Game $game) {
                    $html = '';
                    if ($game->nft) {
                        $html = '<a href="#" data-toggle="tooltip" data-placement="top" title="NFT Support" data-original-title="NFT Support">Yes</a>';
                    }
                    else {
                        $html = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="No NFT Support" data-original-title="No NFT Support">No</a>';
                    }
                    return $html;
                })
                ->editColumn('f2p', function(Game $game) {
                    $html = '';
                    if (strtolower($game->f2p) == 'free-to-play') {
                        $html = '<a href="#" data-toggle="tooltip" data-placement="top" title="Free-To-Play" data-original-title="Free-To-Play">Yes</a>';
                    }
                    else if (strtolower($game->f2p) == 'nft required') {
                        $html = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="NFT Required" data-original-title="NFT Required">NFT</a>';
                    }
                    else if (strtolower($game->f2p) == 'crypto required') {
                        $html = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="Crypto Required" data-original-title="Crypto Required">Crypto</a>';
                    }
                    else if (strtolower($game->f2p) == 'game required') {
                        $html = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="Game Required"" data-original-title="Game Required">Game</a>';
                    }
                    return $html;
                })
                ->addColumn('rating', function(Game $game) {
                    return '<div class="ratings visible" data-toggle="tooltip" data-placement="top" title="'.number_format($game->rating(), 1).'" data-original-title="'.number_format($game->rating(), 1).'">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:'.round(($game->rating()/5)*100, 2).'%"></div>
                            </div>
                            <div class="average">
                                ('.$game->reviews()->count().')
                            </div>';
                })
                ->addColumn('action', function(Game $game){
                    return '<div class="btn-group dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                    Action<span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="'.action('GameController@edit', ['id' => $game->id]).'">Edit</a>
                                    <a class="dropdown-item" href="'.action('GameController@destroy', ['id' => $game->id]).'">Delete</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['name', 'genre', 'blockchain', 'device', 'status', 'nft', 'f2p', 'rating', 'action'])
                ->make(true);
        }

        return view('game.mygames');
    }
}
