<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Get a list of users.
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->success([
            'users' => $users->transform(function (User $user){
                return $user->format();
            }),
        ]);
    }
}
