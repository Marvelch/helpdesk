<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestHardwareSoftware extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'request_hardware_software';

    protected $fillable = [
        'unique_request',
        'requests_from_users',
        'description',
        'status',
        'transaction_date',
        'approval_supervisor',
        'approval_manager',
        'ticketId',
        'approval_general_manager',
        'user_supervisor',
        'request_ticket_id',
        'user_manager_id',
        'division_id',
        'user_general_manager_id',
        'created_by_user_id'
    ];

    public function users() {
        return $this->belongsTo(User::class,'created_by_user_id','id');
    }

    public function userRequest() {
        return $this->belongsTo(User::class,'requests_from_users','id');
    }

    public function division() {
        return $this->belongsTo(division::class,'division_id','id');
    }
}
