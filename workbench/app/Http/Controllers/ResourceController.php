<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnwrappedUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function collection(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function paginated(): AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate());
    }
}
