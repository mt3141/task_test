<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        //only admins can see users list
        if(Gate::allows('is_admin')) {
            $users = User::with('tasks')->get();
        }

        return response()->json([
            'users' => isset($users) ? $users : [],
            'message' => isset($users) ? '' : 'شما مجوز دسترسی به این بخش را ندارید',
        ]);

    }
}
