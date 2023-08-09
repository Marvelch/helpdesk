<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    protected $fillable = [
        'division',
        'company_id'
    ];

    public function company() {
        return $this->belongsTo(company::class,'company_id');
    }
}
