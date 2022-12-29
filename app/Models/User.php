<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'slug',
        'email_status',
        'created_by'
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name','last_name']
            ]
        ];
    }

    public function getIsCustomerAttribute()
    {
        return $this->role_id == Role::CUSTOMER;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name." ".$this->last_name; 
    }
    public function getIsEmailActiveAttribute()
    {
        return $this->email_status == true;
    }
    public function getIsAdminAttribute()
    {
        return $this->role_id == Role::ADMIN;
    }

    public function getIsManagerAttribute()
    {
        return $this->role_id == Role::MANAGER;
    }

    public function getIsEmployeeAttribute()
    {
        return $this->role_id == Role::EMPLOYEE;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeManager($query)
    {
        return $query->where('role_id', Role::MANAGER);
    }
    public function scopeVisibleTo($query,User $user)
    {
        return $query->where('created_by', $user->id);
    }
}
