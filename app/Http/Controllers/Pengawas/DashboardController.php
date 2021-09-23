<?php

namespace App\Http\Controllers\Pengawas;

use App\Models\Admin;
use App\Models\Wapiku;
use App\Models\Pengaduan;
use App\Models\JwtSession;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\NotifTemplate;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    function sendMsg(Request $request, $pengaduan)
    {
        $user = JwtSession::user();
        Conversation::create([
            'pengaduan_id' => $pengaduan,
            'replied_by' => $user->nama,
            'replied_by_id' => $user->user_id,
            'messages'     => $request->messages
        ]);

        $pengaduan = Pengaduan::find($pengaduan);

        // user notif
        $notif = NotifTemplate::where('send_to','user')->where('event_name','chat_baru')->first();
        if($notif)
        {
            $message = $notif->template_text;

            $message = str_replace('[nama]', $pengaduan->pengadu->nama, $message);
            $message = str_replace('[alamat]', $pengaduan->pengadu->alamat, $message);
            $message = str_replace('[nomor_hp]', $pengaduan->pengadu->nomor_hp, $message);
            $message = str_replace('[judul]', $pengaduan->judul, $message);
            $message = str_replace('[deskripsi]', $pengaduan->deskripsi, $message);
            $message .= '\n\n_Ini adalah sistem notifikasi Whatsapp by: Dinas Kominfo Kabupaten Labuhanbatu Utara._';
            Wapiku::send($pengaduan->pengadu->nomor_hp, $message);
        }

        // admin notif
        $notif = NotifTemplate::where('send_to','admin')->where('event_name','chat_baru')->first();
        if($notif)
        {
            $message = $notif->template_text;

            $message = str_replace('[nama]', $pengaduan->pengadu->nama, $message);
            $message = str_replace('[alamat]', $pengaduan->pengadu->alamat, $message);
            $message = str_replace('[nomor_hp]', $pengaduan->pengadu->nomor_hp, $message);
            $message = str_replace('[judul]', $pengaduan->judul, $message);
            $message = str_replace('[deskripsi]', $pengaduan->deskripsi, $message);
            $message .= '\n\n_Ini adalah sistem notifikasi Whatsapp by: Dinas Kominfo Kabupaten Labuhanbatu Utara._';
            $admin = Admin::get();
            foreach($admin->pegawai as $pegawai)
            {
                $nomor_hp = preg_replace('/^0/','62',$pegawai->no_hp);
                Wapiku::send($nomor_hp, $message);
            }

            foreach($admin->tks as $pegawai)
            {
                $nomor_hp = preg_replace('/^0/','62',$pegawai->no_hp);
                Wapiku::send($nomor_hp, $message);
            }
        }

        return ['status'=>'success'];
    }

    function conversation($pengaduan)
    {
        $conversations = Conversation::where('pengaduan_id',$pengaduan)->with(['pengaduan','pengaduan.pengadu'])->get()->toArray();
        return $conversations;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
