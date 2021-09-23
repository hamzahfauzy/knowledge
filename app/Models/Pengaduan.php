<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $guarded = [];

    function getIdPengaduanAttribute()
    {
        $time = strtotime($this->created_at);
        return $time . $this->id;
    }

    function riwayat()
    {
        return $this->hasOne(Riwayat::class)->orderby('created_at','desc');
    }

    function riwayats()
    {
        return $this->hasMany(Riwayat::class);
    }

    function pihaks()
    {
        return $this->hasMany(Pihak::class);
    }

    function buktis()
    {
        return $this->hasMany(Bukti::class);
    }

    function getStatusLabelAttribute()
    {
        $alert = [
            'Baru' => 'badge badge-primary',
            'Di Proses' => 'badge badge-warning',
            'Selesai' => 'badge badge-success',
            'Di Arsipkan' => 'badge badge-secondary',
            'Di Tolak' => 'badge badge-danger',
        ];

        return '<div class="'.$alert[$this->riwayat->status].'">'.$this->riwayat->status.'</div>';
    }

    function getLabelNamaAttribute()
    {
        if($this->privasi == 'Ya')
            return '<i>Nama disembunyikan</i>';
        return $this->pengadu->nama;
    }

    function pengadu()
    {
        return $this->hasOne(Pengadu::class);
    }

    function conversations()
    {
        return $this->hasManu(Conversation::class);
    }
}
