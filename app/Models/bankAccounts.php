<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bankAccounts extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $fillable = [
        'email',
        'fullname',
        'username',
        'url',
        'description',
        'password',
        'attachment',
        'created_by_user_id',
        'ip_address',
        'anydesk'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
