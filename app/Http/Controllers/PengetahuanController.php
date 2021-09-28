<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\JwtSession;

class PengetahuanController extends Controller
{
    function __construct()
    {
        $this->category = new Category;
        $this->model    = new Post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user  = JwtSession::user();
        $model = $this->model->where('posted_by_id',$user->user_id)->get();
        return view('pengetahuan.index',compact('model'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = $this->category->get();
        return view('pengetahuan.create',compact('categories'));
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
        $user = JwtSession::user();
        $slug = \Str::slug($request->title);
        $request['slug'] = $this->model->slugs($slug);
        $data = $request->all();
        $data['posted_by_id'] = $user->user_id;
        $data['posted_by_name'] = $user->nama;
        $data['opd_id'] = $user->skpd_id;
        $data['opd_name'] = $user->nama_opd;
        $pengetahuan = $this->model->create($data);
        if(isset($data['categories']))
            $pengetahuan->categories()->sync($data['categories']);
        if(isset($data['opds']))
        {
            foreach($data['opds'] as $opd)
            {
                $pengetahuan->shares()->create([
                    'post_id' => $pengetahuan->id,
                    'opd_id' => $opd,
                ]);
            }
        }
        return redirect()->route('pengetahuan.edit',$pengetahuan->id)->with('success', 'Pengetahuan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pengetahuan)
    {
        //
        return $pengetahuan;
    }

    public function detail($slug)
    {
        //
        $post = $this->model->where('slug',$slug)->firstOrFail();
        return view('pengetahuan.detail',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pengetahuan)
    {
        //
        $user       = JwtSession::user();
        $categories = $this->category->get();
        $model      = [];
        if($user->role->role_id==1)
            $model      = $this->model->where('id',$pengetahuan)->firstOrFail();
        else
            $model      = $this->model->where('id',$pengetahuan)->where('posted_by_id',$user->user_id)->firstOrFail();
        $selected_categories = $model->categories?$model->categories()->pluck('post_categories.category_id')->toArray():[];
        return view('pengetahuan.edit',compact('categories','model','selected_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pengetahuan)
    {
        //
        $user       = JwtSession::user();
        $model      = [];
        if($user->role->role_id==1)
            $model      = $this->model->where('id',$pengetahuan)->firstOrFail();
        else
            $model      = $this->model->where('id',$pengetahuan)->where('posted_by_id',$user->user_id)->firstOrFail();
        $model->update($request->all());
        if(isset($request->categories))
            $model->categories()->sync($request->categories);
        else
            $model->categories()->sync([]);

        $model->shares()->delete();
        if(isset($request['opds']))
        {
            foreach($request['opds'] as $opd)
            {
                $model->shares()->create([
                    'post_id' => $model->id,
                    'opd_id' => $opd,
                ]);
            }
        }
        return redirect()->route('pengetahuan.edit',$pengetahuan)->with('success', 'Pengetahuan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function delete($pengetahuan)
    {
        $user       = JwtSession::user();
        $model      = [];
        if($user->role->role_id==1)
            $model      = $this->model->where('id',$pengetahuan)->firstOrFail();
        else
            $model      = $this->model->where('id',$pengetahuan)->where('posted_by_id',$user->user_id)->firstOrFail();
        $model->delete();
        return redirect()->route('pengetahuan.index')->with('success', 'Pengetahuan Berhasil Dihapus');
    }
}
