<?php

namespace App\Http\Controllers;
use App\Blockchain;

use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    public function index() {
        $blockchain = Blockchain::orderBy('cryptocurrency', 'asc')->get();
        return view('blockchain.index', [
            'blockchain' => $blockchain
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'cryptocurrency' => 'required|string|unique:blockchains'
        ]);

        $data = $request->all();
        $data['cryptocurrency'] = str_replace(' ', '-', $data['cryptocurrency']);

        Blockchain::create($data);
        return back()->with('success', 'Blockchain Added');
    }

    public function destroy($id) {
        $blockchain = Blockchain::find($id);
        $blockchain->delete();

        return back()->with('success', 'Blockchain Deleted');
    }
}
