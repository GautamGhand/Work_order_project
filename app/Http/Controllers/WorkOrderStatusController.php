<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\Progress;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderUser;
use App\Notifications\WorkOrderCloseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class WorkOrderStatusController extends Controller
{
    public function create(WorkOrder $workorder)
    {
        return view('users.work-order-status', [
            'workorder' => $workorder,
            'progresses' => $workorder->progresses()->get(),
            'statuses' => Status::get(),
            'managers' => User::manager()->get(),
            'employees' => User::employee()->visibleTo(Auth::user())->get()
        ]);
    }
    public function update(Request $request,WorkOrder $workorder)
    {
        if (WorkOrderUser::userWorkOrder($request)->workOrder($workorder)->first()) {
            return back()->with('error', 'This Work order Assigned to User Already');
        }

        $request->validate([
            'add_note' => 'required|min:5',
            'status_id' => ['required',
                            Rule::in(Status::get()
                                    ->pluck('id')
                        )]
        ]);

        if ($request['status_id'] == Status::RESOLVED) {
            if (Auth::user()->is_manager) {
                $workorder->users()->update([
                    'work_order_id' => $workorder->id,
                    'user_id' => Role::ADMIN,
                    'assigned_by' => Auth::id()
                ]);

                $progress = Progress::create([
                    'work_order_id' => $workorder->id,
                    'note' => $request['add_note'],
                    'user_id' => Auth::id(),
                    'assigned_to' => Role::ADMIN,
                    'status_id' => $request['status_id']
                ]);

                $workorder->update([
                    'status_id' => $request['status_id']
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
            }
            elseif (Auth::user()->is_employee) {
                $progress = Progress::create([
                    'work_order_id' => $workorder->id,
                    'note' => $request['add_note'],
                    'user_id' => Auth::id(),
                    'assigned_to' => WorkOrderUser::where('work_order_id', $workorder->id)->first()->assigned_by,
                    'status_id' => $request['status_id']
                ]);

                $workorder->users()->update([
                    'work_order_id' => $workorder->id,
                    'user_id' => WorkOrderUser::where('work_order_id', $workorder->id)->first()->assigned_by,
                    'assigned_by' => Auth::id()
                ]);

                $workorder->update([
                    'status_id' => $request['status_id']
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

            }
        }
        elseif ($request['status_id'] == Status::OPEN) {
            $workorder->update([
                'status_id' => $request['status_id']
            ]);

            if (Auth::user()->is_manager || Auth::user()->is_admin) {
                $workorder->users()->update([
                    'work_order_id' => $workorder->id,
                    'user_id' => $request['user_id'],
                    'assigned_by' => Auth::id()
                ]);

                $progress = Progress::create([
                    'work_order_id' => $workorder->id,
                    'note' => $request['add_note'],
                    'user_id' => Auth::id(),
                    'assigned_to' => $request['user_id'],
                    'status_id' => $request['status_id']
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
            }
        }
        elseif ($request['status_id'] == Status::CLOSE) {
            $workorder->update([
                'status_id' => $request['status_id']
            ]);

            if (Auth::user()->is_admin) {
                $user_id = Progress::where('note', null)->first()->user_id;
                $user = User::find($user_id);

               $progress = Progress::create([
                    'work_order_id' => $workorder->id,
                    'note' => $request['add_note'],
                    'user_id' => Auth::id(),
                    'assigned_to' => Progress::where('note', null)->first()->user_id,
                    'status_id' => $request['status_id']
                ]);

                $workorder->users()->update([
                    'work_order_id' => $workorder->id,
                    'user_id' => Progress::where('note', null)->first()->user_id,
                    'assigned_by' => Auth::id()
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
            }

            Notification::send($user,new WorkOrderCloseNotification(Auth::user(),$workorder));

        }
        elseif($request['status_id'] == Status::IN_PROGRESS)
        {
            $workorder->update([
                'status_id' => $request['status_id']
            ]);

        }

        return redirect()->route('dashboard')->with('success', 'Status changed Successfully');
    }
}
