<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caulacboModel extends Model
{
    use HasFactory;
    // gọi table 'clb' để truyền one to many
    protected $table = 'fanpages';
    public function getThanhVien()
    {
        return $this -> hasMany('App\Models\ThanhVienModel','fanpage_id');
    }
}
