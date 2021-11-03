<?php

namespace App\Http\Controllers;

use App\Game;
use App\Announcement;
use App\Genre;
use Auth;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::where('is_approved', 1);

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
                ->rawColumns(['name', 'genre', 'blockchain', 'device', 'status', 'nft', 'f2p', 'rating'])
                ->make(true);
        }

        $announcement = Announcement::latest()->first();

        return view('game.index',[
            'announcement' => $announcement
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genre = Genre::orderBy('genre', 'asc')->get();
        return view('game.create', [
            'genre' => $genre
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre' => 'required|array',
            'blockchain' => 'required|array',
            'device' => 'required|array',
            'status' => 'required|string',
            'nft' => 'required|boolean',
            'f2p' => 'required|string',
            'screenshots.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = str_replace(' ', '_', $request->name).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/game-profile'), $imageName);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['image'] = $imageName;
        $data['genre'] = implode(',', $request->genre);
        $data['blockchain'] = implode(',', $request->blockchain);
        $data['device'] = implode(',', $request->device);

        if ($request->hasfile('screenshots')) {
            $count = 1;
            $screenshots = array();
            foreach($request->file('screenshots') as $file) {
                $name = str_replace(' ', '_', $request->name).'_img'.$count.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images/game-screenshots'), $name);
                $screenshots[] = $name;
                $count++;
            }
            $data['screenshots'] = implode(',', $screenshots);
        }

        Game::create($data);

        return back()->with('success', 'Game Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);
        
        $status = '';
        if (ucfirst($game->status) == 'Live') {
            $status = '<a href="#" class="status" style="color: #5cd958;border: 1px solid #5cd958">Live</a>';
        }
        else if (ucfirst($game->status) == 'Presale') {
            $status = '<a href="#" class="status" style="color: #c60c0c;border: 1px solid #c60c0c">Presale</a>';
        }
        else if (ucfirst($game->status) == 'Alpha') {
            $status = '<a href="#" class="status" style="color: #1188ff;border: 1px solid #1188ff">Alpha</a>';
        }
        else if (ucfirst($game->status) == 'Beta') {
            $status = '<a href="#" class="status" style="color: #ffb700;border: 1px solid #ffb700">Beta</a>';
        }
        else if (ucfirst($game->status) == 'Development') {
            $status = '<a href="#" class="status" style="color: #4700ff;border: 1px solid #4700ff">Development</a>';
        }
        else if (ucfirst($game->status) == 'Cancelled') {
            $status = '<a href="#" class="status" style="color: #9a9a9a;border: 1px solid #9a9a9a">Cancelled</a>';
        }

        $genre = explode(',', $game->genre);
        $blockchain = explode(',', $game->blockchain);
        $device = explode(',', $game->device);

        $nft = '';
        if ($game->nft) {
            $nft = '<a href="#" data-toggle="tooltip" data-placement="top" title="NFT Support" data-original-title="NFT Support">Yes</a>';
        }
        else {
            $nft = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="No NFT Support" data-original-title="No NFT Support">No</a>';
        }

        $f2p = '';
        if (strtolower($game->f2p) == 'free-to-play') {
            $f2p = '<a href="#" data-toggle="tooltip" data-placement="top" title="Free-To-Play" data-original-title="Free-To-Play">Yes</a>';
        }
        else if (strtolower($game->f2p) == 'nft required') {
            $f2p = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="NFT Required" data-original-title="NFT Required">NFT</a>';
        }
        else if (strtolower($game->f2p) == 'crypto required') {
            $f2p = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="Crypto Required" data-original-title="Crypto Required">Crypto</a>';
        }
        else if (strtolower($game->f2p) == 'game required') {
            $f2p = '<a href="#" class="none" data-toggle="tooltip" data-placement="top" title="Game Required"" data-original-title="Game Required">Game</a>';
        }

        $screenshots = explode(',', $game->screenshots);

        $total_ratings = $game->reviews()->count();
        $ratings = [
            '5_stars' => 0,
            '4_stars' => 0,
            '3_stars' => 0,
            '2_stars' => 0,
            '1_stars' => 0,
        ];
        $total_stars = 0;
        $average_stars = 0;
        foreach($game->reviews()->get() as $review) {
            $ratings[$review->rating.'_stars'] += 1;
            $total_stars += $review->rating;
            $average_stars = $total_stars/$total_ratings;
        }
        
        return view('game.view', [
            'game' => $game,
            'status' => $status,
            'genre' => $genre,
            'blockchain' => $blockchain,
            'device' => $device,
            'nft' => $nft,
            'f2p' => $f2p,
            'screenshots' => $screenshots,
            'total_ratings' => $total_ratings,
            'ratings' => $ratings,
            'average_stars' => $average_stars
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $game = Game::find($id);

        if (Auth::user()->id != $game->user_id) {
            abort(401, 'You are not authorized to edit this game');
        }

        $all_genre = Genre::orderBy('genre', 'asc')->get();

        $genre = explode(',', $game->genre);
        $blockchain = explode(',', $game->blockchain);
        $device = explode(',', $game->device);

        return view('game.edit', [
            'game' => $game,
            'genre' => $genre,
            'blockchain' => $blockchain,
            'device' => $device,
            'all_genre' => $all_genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre' => 'required|array',
            'blockchain' => 'required|array',
            'device' => 'required|array',
            'status' => 'required|string',
            'nft' => 'required|boolean',
            'f2p' => 'required|string',
            'screenshots.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['genre'] = implode(',', $request->genre);
        $data['blockchain'] = implode(',', $request->blockchain);
        $data['device'] = implode(',', $request->device);

        if ($request->hasfile('screenshots')) {
            $imageName = str_replace(' ', '_', $request->name).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/game-profile'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasfile('screenshots')) {
            $count = 1;
            $screenshots = array();
            foreach($request->file('screenshots') as $file) {
                $name = str_replace(' ', '_', $request->name).'_img'.$count.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images/game-screenshots'), $name);
                $screenshots[] = $name;
                $count++;
            }
            $data['screenshots'] = implode(',', $screenshots);
        }

        $data['is_approved'] = 0;

        $game = Game::find($id);
        $game->update($data);

        return back()->with('success', 'Game Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        $game->delete();

        return redirect(action('ProfileController@index'));
    }

    public function pending() {
        $games = Game::where('is_approved', 0);

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
                    return '<a class="btn btn-success" href="'.action('GameController@approve', ['id' => $game->id]).'">Approve Game</a>';
                })
                ->rawColumns(['name', 'genre', 'blockchain', 'device', 'status', 'nft', 'f2p', 'rating', 'action'])
                ->make(true);
        }

        return view('game.pending');
    }

    public function approve($id) {
        $game = Game::find($id);
        $game->update(['is_approved' => 1]);
        
        return redirect(action('GameController@pending'));
    }
}
