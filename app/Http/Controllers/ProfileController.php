<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user
        ]);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = $request->user();

        if ($request->image) {
            $imageName = str_replace(' ', '_', $request->name).'_id'.$user->id.'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/user-profile'), $imageName);
        }
        else {
            $imageName = 'user.png';
        }

        $data = $request->all();
        $data['image'] = $imageName;
        
        $user->update($data);

        return back()->with('success', 'Profile Updated');
    }
}
