<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnwrappedUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class ResourceController
{
    public function show(): UserResource
    {
        return new UserResource(User::first());
    }

    public function unwrapped(): UnwrappedUserResource
    {
        return new UnwrappedUserResource(User::first());
    }
}
