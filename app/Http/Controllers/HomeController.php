<?php

namespace App\Http\Controllers;

use App\Models\url;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function showUrl($code = null)
    {
        # code...
        if ($code) {
            $url = url::where('code', $code)->first();
            $url->views +=  1;
            $url->save();
            return redirect()->to($url->url);
        } else {
            return redirect()->route('urls.index');
        }
    }
}
