<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
}
