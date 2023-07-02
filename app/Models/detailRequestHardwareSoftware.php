<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detailRequestHardwareSoftware extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'detail_request_hardware_software';

    protected $fillable = [
        'unique_request',
        'items_id',
        'items_new_request',
        'qty',
        'availability',
        'transaction_status',
        'description'
    ];

    public function inventorys() {
        return $this->belongsTo(inventory::class,'items_id','id');
    }
}
