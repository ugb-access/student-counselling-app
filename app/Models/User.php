<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['email', 'name', 'username', 'password', 'role_id', 'phone_number', 'added_by_user_id'];

    protected $hidden = ['password', 'remember_token', 'updated_at'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role()->where('name', $role)->exists();
    }


    public function student() {
        return $this->hasOne(Student::class);
    }

    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by_user_id')->withDefault(); // Use withDefault to handle null values
    }
   
}



