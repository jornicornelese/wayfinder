<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class InertiaController
{
    public function dashboard(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'users' => 100,
                'posts' => 50,
                'views' => 10000,
            ],
            'recentActivity' => [],
        ]);
    }

    public function settings(): Response
    {
        return Inertia::render('Settings/General', [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            'preferences' => [
                'theme' => 'dark',
                'notifications' => true,
            ],
        ]);
    }

    public function profile(): Response
    {
        return Inertia::render('Profile/Show', [
            'profile' => [
                'bio' => 'Hello world',
                'avatar' => null,
            ],
        ]);
    }

    public function resources(): Response
    {
        return Inertia::render('Resources', [
            'users' => UserResource::collection(User::all()),
            'paginatedUsers' => UserResource::collection(User::paginate()),
            'singleUser' => UserResource::make(User::first()),
        ]);
    }

    public function unsafe(): Response
    {
        return Inertia::render('settings/two-factor', [
            'user' => [
                'name' => 'Jane Doe',
                'email' => 'jane@doe.co',
            ],
        ]);
    }
}
