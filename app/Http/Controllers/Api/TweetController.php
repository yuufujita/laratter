<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// 追加
use App\Http\Requests\StoreTweetRequest;
// 追加
use App\Http\Requests\UpdateTweetRequest;
use Illuminate\Http\Request;
// 追加
use App\Models\Tweet;
// 追加
use App\Services\TweetService;

class TweetController extends Controller
{
    // 追加
    protected $tweetService;
    
    // 追加
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 2回目の講義　$tweets = Tweet::with('user')->latest()->get();
        // 3回目の講義にて追加
        $this->authorize('viewAny', Tweet::class);
        $tweets = $this->tweetService->allTweets();
        return response()->json($tweets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetRequest $request)
    {
        /* 2回目の講義にて記述　→ 3回目の講義にて削除　
        $request->validate([
            'tweet' => 'required|max:255',
        ]);
        $tweet = $request->user()->tweets()->create($request->only('tweet'));
        */

        // 3回目の講義にて追加
        $this->authorize('create', Tweet::class);
        $tweet = $this->tweetService->createTweet($request->only('tweet'), $request->user());
        return response()->json($tweet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        // 追加
        $this->authorize('view', $tweet);
        return response()->json($tweet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        /* 2回目の講義にて記述　→ 3回目の講義にて削除
        $request->validate([
            'tweet' => 'required|string|max:255',
        ]);
        $tweet->update($request->all());
        */
        // 3回目の講義にて追加
        $this->authorize('update', $tweet);
        $updatedTweet = $this->tweetService->updateTweet($tweet, $request->all());
        return response()->json($updatedTweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        // 2回目の講義　$tweet->delete();
        // 3回目の講義にて追加
        $this->authorize('delete', $tweet);
        $this->tweetService->deleteTweet($tweet);
        return response()->json(['message' => 'Tweet deleted successfully']);
    }
}
