<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'id_people',
        'email',
        'company_id',
        'level_id',
        'photo',
        'password_text',
        'phone',
        'position_id',
        'division_id',
        'multi_company',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Displays the level of each user
     */
    public function level() {
        return $this->belongsTo(level::class,'level_id','id');
    }

     /**
     * Display company data
     */
    public function company() {
        return $this->belongsTo(company::class,'company_id','id');
    }

    /**
     * Displays a list of divisions in the company
     */
    public function division() {
        return $this->belongsTo(division::class,'division_id','id');
    }
}
