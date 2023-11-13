<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'News';

    protected $fillable = [
        'title',
        'article',
        'status',
        'img',
        'created_user_id'
    ];

    public function users() {
        return $this->belongsTo(User::class,'created_user_id','id');
    }
}
