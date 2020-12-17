<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::orderBy('created_at', 'DESC')
        ->with(['user' => fn ($q) => $q->withCount([
            'followers as isFollowing' => fn ($q) => $q
                ->where('follower_id', auth()->user()->id)])
                ->withCasts(['isFollowing' => 'boolean'])
        ])->get();

        return Inertia::render('Tweet/Index', [
            'tweets' => $tweets
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['exists:users,id'],
            'content' => ['required', 'max:280']
        ]);

        Tweet::create([
            'user_id' => auth()->user()->id,
            'content' => $request->input('content')
        ]);

        return Redirect::route('tweets.index');
    }

    public function followings()
    {
        $followings = Tweet::with('user')
        ->whereIn('user_id', auth()->user()->followings->pluck('id'))
        ->orderBy('created_at', 'DESC')
        ->with([
            'user' => fn ($q) => $q->withCount([
            'followings as isFollowingUser' => fn ($q) => $q
                ->where('following_id', '=', auth()->user()->id)])
                ->withCasts(['isFollowingUser' => 'boolean'])
        ])->get();

        return Inertia::render('Tweet/Followings', [
            'followings' => $followings
        ]);
    }

    public function profile(User $user)
    {
        $user->loadCount([
            'followers as isFollowing' => fn ($q) =>
                $q->where('follower_id', '=', auth()->user()->id)
                ->withCasts(['isFollowing' => 'boolean']),
            'followings as is_following_you' => fn ($q) => $q->where('following_id', auth()->user()->id)
            ]);

        $tweets = $user->tweets;

        return Inertia::render('Tweet/Profile', [
            'profileUser' => $user,
            'tweets' => $tweets
        ]);
    }

    public function unfollows(User $user)
    {
        Auth::user()->followings()->detach($user);

        return redirect()->back();
    }

    public function follows(User $user)
    {
        Auth::user()->followings()->attach($user);

        return redirect()->back();
    }
}
