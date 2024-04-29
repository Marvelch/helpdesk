<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'unique',
        'full_name',
        'company',
        'total_visitor',
        'visitor_name',
        'purpose_of_visit',
        'visit_date',
        'expected_arrival_time',
        'assign_to',
        'employee_name',
        'signature_visitor',
        'signature_employee',
        'status',
        'phone',
        'signature_security',
        'date',
        'in',
        'out',
        'plant'
    ];
}
