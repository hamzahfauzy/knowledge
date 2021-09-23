<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wapiku;
use App\Models\Pengaduan;
use App\Models\JwtSession;
use Illuminate\Http\Request;
use App\Models\NotifTemplate;
use App\Http\Controllers\Controller;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pengaduans = Pengaduan::get();
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Semua Data';
        if($filter != 'Semua Data')
            $pengaduans = $pengaduans->filter(function($item) use ($filter){
                return $item->riwayat->status == $filter;
            });

        return view('admin.pengaduan.index',compact('pengaduans','filter'));
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
    public function show(Pengaduan $pengaduan)
    {
        //
        return view('admin.pengaduan.show',compact('pengaduan'));
    }

    public function updateStatus(Pengaduan $pengaduan, $status)
    {
        $user = JwtSession::user();
        $pengaduan->riwayat->create([
            'pengaduan_id' => $pengaduan->id,
            'updated_by'   => $user->nama,
            'role'         => $user->role->name,
            'status'       => $status
        ]);

        $event_name = [
            'Di Arsipkan' => 'pengaduan_arsip',
            'Di Proses'   => 'pengaduan_proses',
            'Selesai'     => 'pengaduan_selesai'
        ];

        $pengadu = $pengaduan->pengadu;
        if($pengadu)
        {
            // notif user
            $notif = NotifTemplate::where('send_to','user')->where('event_name',$event_name[$status])->first();
            if($notif)
            {
                $message = $notif->template_text;

                $message = str_replace('[nama]', $pengadu->nama, $message);
                $message = str_replace('[alamat]', $pengadu->alamat, $message);
                $message = str_replace('[nomor_hp]', $pengadu->nomor_hp, $message);
                $message = str_replace('[judul]', $pengaduan->judul, $message);
                $message = str_replace('[deskripsi]', $pengaduan->deskripsi, $message);
                $message .= '\n\n_Ini adalah sistem notifikasi Whatsapp by: Dinas Kominfo Kabupaten Labuhanbatu Utara._';
                Wapiku::send($pengadu->nomor_hp, $message);
            }
        }

        return redirect()->route('admin.pengaduan.show',$pengaduan->id)->with('success','Pengaduan berhasil di update');
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
