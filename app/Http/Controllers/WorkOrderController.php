<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\Progress;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('users.work-orders', [
            'workorders' => WorkOrder::whereHas('users', function(Builder $query) {
                                    $query->where('user_id', Auth::id());
                                })->get(),
            'allworkorders' => WorkOrder::paginate(10)
        ]);
    }
    public function create()
    {
        return view('customers.work-order-create');
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|max:255|min:3',
            'note' => 'required|min:5'
        ]);

        $attributes += [
            'created_by' => Auth::id(),
            'status_id' => Status::OPEN
        ];
        
        $workorder = WorkOrder::create($attributes);

        WorkOrderUser::create([
            'user_id' => Role::ADMIN,
            'work_order_id' => $workorder->id,
            'assigned_by' => Auth::id()
        ]);

        $progress = Progress::create([
            'work_order_id' => $workorder->id,
            'user_id' => Auth::id(),
            'assigned_to' => Role::ADMIN,
            'status_id' => Status::OPEN
        ]);

        if ($request['file']) {

            $attachment = $request->file('file')->store('/attachments');

            Attachement::create([
                'url' => $attachment,
                'extension' => $request->file('file')->extension(),
                'work_order_id' => $workorder->id,
                'attachmentable_id' => $progress->id,
                'attachmentable_type' => 'App\Models\Progress'
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Work order Created Successfully');
    }
}
