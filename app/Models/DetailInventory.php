<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInventory extends Model
{
    use HasFactory;

    protected $table = 'detail_inventories';

    protected $fillable = [
        'inventory_unique',
        'stock_in',
        'stock_out',
        'adjustment',
        'created_by_user_id',
        'description'
    ];

    public function users() {
        return $this->belongsTo(User::class,'created_by_user_id','id');
    }
}
