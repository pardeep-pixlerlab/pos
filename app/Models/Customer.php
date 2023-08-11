<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasApiTokens,Notifiable,HasRoles,HasFactory;
   
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'password',
        'avatar',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getAvatarUrl()
    {
        return Storage::url($this->avatar);
    }
  
}
