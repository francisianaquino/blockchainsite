<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if (request()->ajax()) {
            return DataTables::of($users)
                ->editColumn('is_admin', function(User $user) {
                    if ($user->is_admin) {
                        return 'Admin';
                    }
                    else {
                        return 'User';
                    }
                })
                ->editColumn('email_verified_at', function(User $user) {
                    if (isset($user->email_verified_at)) {
                        return $user->email_verified_at->format("F j, Y, g:i a");
                    }
                    else {
                        return 'Not Yet Verified';
                    }
                })
                ->addColumn('action', function(User $user) {
                    return '<div class="btn-group dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                    Action<span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="'.action('UserController@edit', ['id' => $user->id]).'">Edit</a>
                                    <a class="dropdown-item" href="'.action('UserController@destroy', ['id' => $user->id]).'">Delete</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', [
            'user' => $user
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
            'is_admin' => 'required|integer|between:0,1'
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'is_admin' => $request->is_admin,
        ]);

        return redirect(action('UserController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect(action('UserController@index'));
    }
}
