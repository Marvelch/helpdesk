<?php

namespace App\Models;

use App\Http\Resources\Company;
use App\Models\company as ModelsCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requestTicket extends Model
{
    use HasFactory;

    protected $table = 'request_tickets';

    protected $fillable = [
        'request_on_user_id',
        'assignment_on_user_id',
        'title',
        'company_id',
        'division_id',
        'deadline',
        'type_of_work_id',
        'status',
        'location',
        'description',
        'attachment'
    ];

    public function usersReq() {
        return $this->belongsTo(User::class,'request_on_user_id','id');
    }

    public function usersAss() {
        return $this->belongsTo(User::class,'assignment_on_user_id','id');
    }

    public function company() {
        return $this->belongsTo(ModelsCompany::class,'company_id','id');
    }

    public function division() {
        return $this->belongsTo(division::class,'assignment_on_user_id','id');
    }

    public function typeOfWork() {
        return $this->belongsTo(WorkType::class,'type_of_work_id','id');
    }
}
