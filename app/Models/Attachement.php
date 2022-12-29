<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachement extends Model
{
    use HasFactory;

    protected $table='attachments';

    protected $fillable = [
        'work_order_id',
        'url',
        'extension',
        'attachmentable_id',
        'attachmentable_type'
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
