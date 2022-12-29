<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_orders';

    protected $fillable = [
        'title',
        'note',
        'status_id',
        'created_by'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('id')
                    ->using(WorkOrderUser::class);
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'attachmentable');
    }
}
