<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'expire_at',
        'email',
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

    public function genrateCode()
    {
       $this->timestamps=false;
       $this->code=rand(1,100000);
       $this->expire_at=now()->addDay(90);
       $this->save();      
    }
    public function resetCode()
    {
       $this->timestamps=false;
       $this->code=null;
       $this->expire_at=null;
       $this->save();      
    }
}
