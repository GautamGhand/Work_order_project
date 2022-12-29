<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    const OPEN = 1;
    CONST IN_PROGRESS=2;
    CONST RESOLVED=3;
    const CLOSE = 4;

}
