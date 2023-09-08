<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhVienModel extends Model
{

    //gọi table 'thanhvien'
    use HasFactory;
    protected $table ='thanhvien';
  
}
