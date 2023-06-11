<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeOfWork extends Model
{
    use HasFactory;

    protected $table = 'type_of_works';

    protected $fillable = [
        'typeofwork',
    ];
}
