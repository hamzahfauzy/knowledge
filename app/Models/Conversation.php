<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    function getDateAttribute()
    {
        $timestamp = strtotime($this->created_at);	
	   
	    $strTime = array("detik", "menit", "jam", "hari", "bulan", "tahun");
	    $length = array("60","60","24","30","12","10");

	    $currentTime = time();
	    if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . " yang lalu";
	    }

        return $this->created_at;
    }
}
