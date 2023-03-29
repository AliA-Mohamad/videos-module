<?php

namespace Modules\Videos\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VideosController extends Controller
{
    public function index()
    {
        return view('videos::index');
    }

    public function salvaTempoTotal(Request $request)
    {
        $tempo = $request->input('tempoTotal');
        session(['tempoTotal' => $tempo]);
        return response()->json(['status' => 'success']);
    }
    
}
