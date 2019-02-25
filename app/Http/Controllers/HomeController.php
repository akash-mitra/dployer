<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $droplets = auth()->user()->droplets;

        return view('home', compact('droplets'));
    }

    public function view($do_id)
    {
        // $droplet = auth()->user()->droplets->where('do_id', $do_id)->first();

        // $server = $droplet->getServer();

        // return view('blog.show', [
        //     'droplet' => $droplet,
        //     'server' => $server
        // ]);

        return view('blog.show');
    }

    public function create()
    {
        return view('blog.create', [
            'subscribed' => auth()->user()->subscribed('Platonics Primary')
        ]);
    }
}
