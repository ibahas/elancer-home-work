<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    protected $rules = [
        'url' => ['required', 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
    ];


    protected $messages = [
        'url.required' => 'The :attribute field is mandatory.'
    ];
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $urls = url::where('user', Auth::user()->id)->paginate();


        return view('urls.index', [
            'urls' => $urls,
            'title' => 'Urls',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $url = new url;
        return view('urls.create', compact('url'));
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
        // dd($request->all());
        $clean = $request->validate($this->rules(), $this->messages);
        $data = [
            'code' =>  Str::random(5),
            'url' => $request->url,
            'views' => 0,
            'user' => Auth::user()->id
        ];


        $url = url::create($data);


        // PRG: Post Redirect Get
        return redirect()
            ->route('urls.index')
            ->with('success', 'Url created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(url $url)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(url $url)
    {
        //
        return view('urls.edit', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, url $url)
    {
        //
        $clean = $request->validate($this->rules(), $this->messages);

        $url->update($request->all());


        // PRG: Post Redirect Get
        return redirect()
            ->route('urls.index')
            ->with('success', 'Url updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(url $url)
    {
        //
        url::destroy($url->id);


        return redirect()
            ->route('urls.index')
            ->with('success', 'Url deleted!');
    }

    protected function rules()
    {
        $rules = $this->rules;
        return $rules;
    }
}
