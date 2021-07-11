<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{
    public function show($id): RedirectResponse|JsonResponse
    {
        try {
            $link = Link::find($id);
            $link->hits++;
            $link->save();
            return Redirect::to($link->url, 301);
        } catch (\Throwable $throwable) {
            abort(500);
        }

    }

    public function store(StoreLinkRequest $request)
    {
        $user = User::whereName($request->user_id)->first();
        if (!$user) {
            return response()->json([
                'error' => 'User not found!'
            ], 404);
        }
        try {
            $link = Link::create([
                'user_id' => $user->id,
                'url' => $request->url,
            ]);
            return $link;
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Link::destroy($id);
            return response(status: 204);
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    public function stats($id = null)
    {
        try {
            if ($id) {
                return Link::find($id);
            }
            $links = Link::all();
            return response()->json([
                'hits' => $links->sum('hits'),
                'urlCount' => $links->count(),
                'topUrls' => $links->sortByDesc('hits')->take(10)
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => $throwable->getMessage()
            ], 500);
        }
    }
}
