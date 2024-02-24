<?php

namespace App\Http\Controllers;

// 追加
use App\Http\Requests\StoreTweetRequest;
// 追加
use App\Http\Requests\UpdateTweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
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
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 追加
        $this->authorize('create', Tweet::class);
        return view('tweets.create');
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
        $request->user()->tweets()->create($request->only('tweet'));
        */

        // 3回目の講義にて追加
        $this->authorize('create', Tweet::class);
        $tweet = $this->tweetService->createTweet($request->only('tweet'), $request->user());
        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        // 追加
        $this->authorize('view', $tweet);
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        // 追加
        $this->authorize('update', $tweet);
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        /* 2回目の講義にて記述　→ 3回目の講義にて削除
        $request->validate([
            'tweet' => 'required|max:255',
        ]);
        $tweet->update($request->only('tweet'));
        */
        // 3回目の講義にて追加
        $this->authorize('update', $tweet);
        $updatedTweet = $this->tweetService->updateTweet($tweet, $request->all());
        return redirect()->route('tweets.show', $tweet);
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
        return redirect()->route('tweets.index');
    }
}
