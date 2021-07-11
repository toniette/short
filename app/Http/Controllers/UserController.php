<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        if (User::whereName($request->id)->first()) {
            return response(status: 409);
        }

        try {
            User::create([
                'name' => $request->id
            ]);
            return response(status: 201);
        } catch (\Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 500);
        }
    }

    public function stats(Request $request)
    {
        $user = User::whereName($request->user_id)->with('links')->first();

        if (!$user) {
            return response(status: 404);
        }

        return response()->json([
            'hits' => $user->links->sum('hits'),
            'urlCount' => $user->links->count(),
            'topUrls' => $user->links->sortByDesc('hits')->take(10)
        ]);
    }

    public function destroy(Request $request)
    {
        try {
            User::whereName($request->user_id)->delete();
            return response(status: 204);
        } catch (\Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 500);
        }
    }
}
