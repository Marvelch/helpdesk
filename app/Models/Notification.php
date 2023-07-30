<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'users_id',
        'path',
        'ticket_id',
        'read'
    ];

    public function tickets() {
        return $this->belongsTo(requestTicket::class,'ticket_id','id');
    }
}
