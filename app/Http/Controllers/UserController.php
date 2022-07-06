<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {

        return UserResource::collection(User::search($request)->sort($request)->paginate((request('per_page') ?? request('itemsPerPage')) ?? 15));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::createRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $tweet = User::create($validator->validated());
        return new UserResource($tweet);
    }
    public function show(Request $request, User $tweet)
    {

        return new UserResource($tweet);
    }
    public function update(Request $request, User $tweet)
    {

        $validator = Validator::make($request->all(), User::updateRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $tweet->update($validator->validated());
        return new UserResource($tweet);
    }
}
