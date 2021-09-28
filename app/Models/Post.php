<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $fillable = ['opd_id','opd_name','posted_by_id','posted_by_name','title','slug','content','visibility','tags'];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'post_categories');
    }

    public function shares()
    {
        return $this->hasMany(PostShare::class);
    }

    public function slugs($slug)
    {
        $data = Post::where('slug',$slug);
        if($data->exists())
        {
            $data = $data->first();
            $slug .= "-".($data->id+1);
        }

        return $slug;
    }

    function stars()
    {
        return $this->hasMany(PostStar::class);
    }

    function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    function getPostedDateAttribute()
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
