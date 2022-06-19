<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'number_phone','birthday'];
     protected $dates = [
        'birthday'
    ];
}
