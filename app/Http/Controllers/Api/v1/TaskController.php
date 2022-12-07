<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\v1\TaskResource;
use App\Http\Resources\v1\UserResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // admin may see all tasks
        if (Gate::allows('is_admin')) {
            $tasks = Task::with('users')->get();
        } else {
            // members only may see their task
            $tasks = $user->tasks;
        }

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function create(CreateTaskRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $task = Task::create($data);
        // user assign to task that created by self
        $user->tasks()->attach($task);

        return response()->json([
            'task' => new TaskResource($task),
            'message' => 'تسک مورد نظر با موفقیت ایجاد شد'
        ]);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $user = auth()->user();
        if (Gate::allows('is_admin')) {
            $task = Task::find($id);
        } else {
            // members may update task that created by self
            $task = Task::where('id', $id)
                ->where('user_id', $user->id)
                ->first();
        }

        if ($task) {
            $data = $request->all();
            $task->update($data);
            $message = 'تسک مورد نظر با موفقیت ویرایش شد';
        } else {
            $message = 'تسک مورد نظر یافت نشد!';
        }

        return response()->json([
            'task' => $task ? new TaskResource($task) : '',
            'message' => $message
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if (Gate::allows('is_admin')) {
            $task = Task::find($id);
        } else {
            // members may delete task that created by self
            $task = Task::where('id', $id)
                ->where('user_id', $user->id)
                ->first();
        }

        if ($task) {
            // when a task deleted all records related to task delete from pivot table
            $task->users()->detach();
            $task->delete();
            $message = 'تسک مورد نظر با موفقیت حذف شد!';
        } else {
            $message = 'تسک مورد نظر یافت نشد!';
        }

        return response()->json([
            'task' => $task ? new TaskResource($task) : '',
            'message' => $message
        ]);
    }

    public function assign($taskId, $userId = null)
    {
        // only admin may assign task to members and self
        if (Gate::allows('is_admin')) {
            // admin may assign task to self with send only taskId parameter to assign method
            $user = $userId ? User::find($userId) : auth()->user();
            $task = Task::find($taskId);
            if ($task && $user) {
                $user->tasks()->attach($task);
                $message = 'تسک مورد نظر با موفقیت به کاربر تخصیص داده شد';
            } else {
                $message = 'تسک یا کاربر مورد نظر یافت نشد!';
            }
        } else {
            $message = 'شما مجوز دسترسی به این بخش را ندارید';
        }

        return response()->json([
            'task' => isset($task) ? new TaskResource($task) : '',
            'user' => isset($user) ? new UserResource($user) : '',
            'message' => $message
        ]);
    }

    public function unassign($taskId, $userId = null)
    {
        // only admin may unassign task to members and self
        if (Gate::allows('is_admin')) {
            $user = $userId ? User::find($userId) : auth()->user();
            $task = Task::find($taskId);
            if ($task && $user) {
                $result = $user->tasks()->detach($task);
                $message = $result == 1 ? 'تسک مورد نظر با موفقیت از تسک های کاربر حذف شد' : 'تسک مورد نظر جزء تسک های کاربر نمی باشد';
            } else {
                $message = 'تسک یا کاربر مورد نظر یافت نشد!';
            }
        } else {
            $message = 'شما مجوز دسترسی به این بخش را ندارید';
        }

        return response()->json([
            'task' => isset($task) ? new TaskResource($task) : '',
            'user' => isset($user) ? new UserResource($user) : '',
            'message' => $message
        ]);
    }
}
