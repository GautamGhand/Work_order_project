<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    CONST ADMIN = 1;
    CONST MANAGER = 2;
    CONST EMPLOYEE = 3;
    CONST CUSTOMER=4;

    protected $fillable = [
        'name'
    ];

    public function scopeManager($query)
    {
        return $query->where('id', self::MANAGER);
    }
    public function scopeNotAdmin($query)
    {
        return $query->where('name', '!=', 'admin');
    }
}
