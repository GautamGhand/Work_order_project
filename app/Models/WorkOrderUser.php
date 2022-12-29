<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkOrderUser extends Pivot
{
    use HasFactory;

    protected $table = 'user_work_order';

    protected $fillable = [
        'user_id',
        'work_order_id',
        'assigned_by',
        'note'
    ];

    public function scopeUserWorkOrder($query,$request)
    {
        return $query->where('user_id', $request['user_id']);
    }

    public function scopeWorkOrder($query,WorkOrder $workorder)
    {
        return $query->where('work_order_id', $workorder->id);
    }
    
}
