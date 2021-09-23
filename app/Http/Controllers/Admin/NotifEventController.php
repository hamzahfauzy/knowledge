<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\NotifTemplate;
use App\Http\Controllers\Controller;

class NotifEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $notif = NotifTemplate::get();
        if($request->isMethod('post'))
        {
            NotifTemplate::truncate();
            $user = $request->user;
            $admin = $request->admin;
            foreach($user as $key => $n)
            {
                NotifTemplate::create([
                    'send_to' => 'user',
                    'event_name' => $key, 
                    'template_text' => $n
                ]);
            }

            foreach($admin as $key => $n)
            {
                NotifTemplate::create([
                    'send_to' => 'admin',
                    'event_name' => $key, 
                    'template_text' => $n
                ]);
            }

            return redirect()->route('admin.notif.index')->with('success','Berhasil Update Notif');
        }
        return view('admin.notif.index',compact('notif'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
