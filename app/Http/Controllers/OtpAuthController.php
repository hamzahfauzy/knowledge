<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wapiku;
use Illuminate\Http\Request;
use App\Models\OneTimePassword;

class OtpAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('otp_auth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        //
        $otp = mt_rand(1000,9999);
        $expired_at = Carbon::now()->addMinutes(2);
        $nomor_hp = '62'.$request->nomor_hp;

        OneTimePassword::where('nomor_hp',$nomor_hp)->where('status','Belum digunakan')->delete();

        OneTimePassword::create([
            'nomor_hp' => $nomor_hp,
            'kode_otp' => $otp,
            'expired_at' => $expired_at,
        ]);
        
        return Wapiku::send($nomor_hp,'Kode OTP Anda adalah '.$otp.'\n\n_Ini adalah sistem notifikasi Whatsapp by: Dinas Kominfo Kabupaten Labuhanbatu Utara. Simpan nomor ini agar link bisa diklik._');
    }

    function verified(Request $request)
    {
        $nomor_hp = '62'.$request->nomor_hp;
        $otp = $request->otp;
        $one_time_password = OneTimePassword::where('nomor_hp',$nomor_hp)
                                ->where('kode_otp',$otp)
                                ->where('status','Belum digunakan')
                                ->where('expired_at', '>', \DB::raw('NOW()'))
                                ->first();

        if($one_time_password)
        {
            $one_time_password->update([
                'status' => 'Sudah Digunakan',
                'expired_at' => \DB::raw('NOW()')
            ]);
            
            // check user
            $user = User::where('email',$nomor_hp);
            if($user->exists())
                session(['user' => $user->first()]);
            session(['otp_auth'=>$nomor_hp]);
            return redirect()->to($_GET['to']);
        }
        return redirect()->to($_GET['to'])->with(['error'=>'OTP tidak valid']);
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
