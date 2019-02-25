<?php

namespace App\Http\Controllers;

use App\Droplet;
use Illuminate\Http\Request;

class DropletController extends Controller
{
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
        //return DigitalOcean::droplet()->getAll();
        return Droplet::where('user_id', '=', auth()->user()->id)->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function updateDomainName(Request $request)
    {
        $droplet = Droplet::where('user_id', '=', auth()->user()->id)
            ->where('do_id', $request->input('do_Id'))
            ->first();

        return $droplet->setDomain($request->input('domain'));
    }

    public function status($do_id)
    {
        $droplet = Droplet::where('user_id', '=', auth()->user()->id)
            ->where('do_id', $do_id)
            ->first();

        return $droplet->getStatus();
    }

    public function ip($do_id)
    {
        $droplet = Droplet::where('user_id', '=', auth()->user()->id)
            ->where('do_id', $do_id)
            ->first();

        return $droplet->getIp();
    }
}
