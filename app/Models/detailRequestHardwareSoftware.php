<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailRequestHardwareSoftware extends Model
{
    use HasFactory;

    protected $table = 'detail_request_hardware_software';

    protected $fillable = [
        'items_id',
        'items_new_request',
        'transaction_status',
        'unique_request',
        'qty',
        'description'
    ];
}
