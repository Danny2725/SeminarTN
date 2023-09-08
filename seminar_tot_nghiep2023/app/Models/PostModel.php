<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    //gọi table 'posts'
    use HasFactory;
    protected $table ='posts';
    public function getImages_Post()
    {
        return $this -> hasMany('App\Models\images_Post_Model','post_id','post_id');
    }
    public function getImages_Null()
    {
        return $this -> hasOne('App\Models\CLB_Model','name','fanpage_name');
    }
    
}
