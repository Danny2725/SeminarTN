<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CLB_Model extends Model
{
    //gọi table 'fanpages'
    use HasFactory;
    protected $table = 'fanpages';
}
