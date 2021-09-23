@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 col-lg-6 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Otentikasi One-Time Password</h3>
                @if($msg = Session::get('error'))
                <div class="alert alert-danger">
                    {{$msg}}
                </div>
                @endif
                <form action="{{route('otp.verified',['to'=>$_GET['to']])}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Nomor HP</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">62</span>
                            </div>
                            <input type="tel" name="nomor_hp" class="form-control" placeholder="Contoh : 8123456789">
                        </div>
                        <button type="button" class="btn btn-primary btn-otp mt-2 btn-sm" onclick="sendOtp(this)"><span id="btn-label">Kirim OTP</span> <span id="timer"></span></button>
                    </div>
                    <div class="verif-otp d-none">
                        <label for="">Kode OTP sudah dikirimkan ke WhatsApp anda</label>
                        <div class="form-group">
                            <label for="">OTP</label>
                            <input type="tel" name="otp" class="form-control">
                            <button class="btn btn-success btn-sm mt-2"><span id="btn-label">Verifikasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
var countdown, timer = 120
async function sendOtp(el)
{
    el.disabled = true
    var nomor_hp = document.querySelector('input[name="nomor_hp"]').value
    if(nomor_hp == '')
    {
        alert('Nomor HP tidak boleh kosong')
        document.querySelector('input[name="nomor_hp"]').focus()
        return false
    }
    var request = await fetch('{{route("otp.send")}}',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": document.querySelector('input[name="_token"]').value
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
            nomor_hp: nomor_hp
        })
    })

    var response = await request.json()
    if(response.status == 'success')
    {
        document.querySelector('#btn-label').innerHTML = 'Menunggu'
        document.querySelector('.btn-otp').disabled = true
        countdown = setInterval(e=>{
            document.querySelector('#timer').innerHTML = '('+ timer +')'
            if(timer == 0)
            {
                el.disabled = false
                document.querySelector('#timer').innerHTML = ''
                clearInterval(countdown)
                document.querySelector('.btn-otp').disabled = false
                document.querySelector('#btn-label').innerHTML = 'Kirim Ulang'
                timer = 120
                return
            }
            timer--
        },1000)

        // verif otp section
        var verifOtp = document.querySelector('.verif-otp')
        verifOtp.classList.remove('d-none')
    }
    console.log(response)
}
</script>
@endsection