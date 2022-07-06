<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Http\Resources\TweetShowResource;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TweetController extends Controller
{
    public function __construct()
    {
        $this->except = ['index'];
        parent::__construct();
    }

    public function index(Request $request)
    {

        return TweetResource::collection(Tweet::search($request)->sort($request)->paginate((request('per_page') ?? request('itemsPerPage')) ?? 15));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tweet::createRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $tweet = Tweet::create($validator->validated());
        return new TweetResource($tweet);
    }
    public function show(Request $request, Tweet $tweet)
    {
        $tweet = ['users' => $tweet->user->name, 'Tweet' => $tweet];
        return new TweetShowResource($tweet);
    }
    public function update(Request $request, Tweet $tweet)
    {

        $validator = Validator::make($request->all(), Tweet::updateRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $tweet->update($validator->validated());
        return new TweetResource($tweet);
    }
    public function destroy(Request $request, Tweet $tweet)
    {
        $tweet->delete();
        return new TweetResource($tweet);
    }
}
