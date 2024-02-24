<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// 追加
use App\Models\Tweet;
// 追加
use App\Services\TweetLikeService;
use Illuminate\Http\Request;

class TweetLikeController extends Controller
{
    // 追加
    protected $tweetLikeService;
    
    // 追加
    public function __construct(TweetLikeService $tweetLikeService)
    {
        $this->tweetLikeService = $tweetLikeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Tweet $tweet)
    {
        // 2回目の講義　$tweet->liked()->attach(auth()->id());
        // 3回目の講義にて追加
        $this->tweetLikeService->likeTweet($tweet, auth()->user());
        return response()->json(['message' => 'Tweet liked successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        // 2回目の講義　$tweet->liked()->detach(auth()->id());
        // 3回目の講義にて追加
        $this->tweetLikeService->dislikeTweet($tweet, auth()->user());
        return response()->json(['message' => 'Tweet disliked successfully']);
    }
}
