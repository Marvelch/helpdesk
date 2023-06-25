<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHardwareSoftware extends Model
{
    use HasFactory;

    protected $table = 'request_hardware_software';

    protected $fillable = [
        'unique_request',
        'requests_from_users',
        'description',
        'transaction_date',
        'created_by_user_id'
    ];
}
