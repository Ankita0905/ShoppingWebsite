<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'name', 'email', 'password', 'user_type',
        'mobile_number', 'address', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function store($inputs = [], $id = null)
    {
        if($id) {
            $this->find($id)->update($inputs);
            return $id;
        }
        else {
            return $this->create($inputs)->id;
        }
    }

    public function verify($email, $otpCode) {
        return $this
            ->where('users.email', $email)
            ->where('users.otp_code', $otpCode)
            ->where('users.user_type', customer())
            ->first();
    }
}
