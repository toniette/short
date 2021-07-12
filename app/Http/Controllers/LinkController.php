<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{
    public function show($id)
    {
        try {
            $link = Link::find($id);
            $link->hits++;
            $link->save();
            return Redirect::to($link->url, 301);
        } catch (\Throwable) {
            abort(404);
        }

    }

    public function store(StoreLinkRequest $request)
    {
        $user = User::whereName($request->user_id)->first();
        if (!$user) {
            return response()->json(status: 404);
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
            $link = Link::find($id);
            if (!$link) {
                return response(status: 404);
            }
            $link->delete();
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
                return Link::find($id) ?? response(status: 404);
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
