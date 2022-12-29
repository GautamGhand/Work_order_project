<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'progress';

    protected $fillable=[
        'work_order_id',
        'note',
        'user_id',
        'assigned_to',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assigned_user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function attachments()
    {
        return $this->hasOne(Attachement::class, 'attachmentable_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    
    public function scopeUserWorkOrder($query,$request)
    {
        return $query->where('user_id', $request['user_id']);
    }

    public function scopeWorkOrder($query,WorkOrder $workorder)
    {
        return $query->where('work_order_id', $workorder->id);
    }
}
