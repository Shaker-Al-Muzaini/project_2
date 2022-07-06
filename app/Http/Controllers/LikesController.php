<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikesResource;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LikeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(Request $request)
    {
        return LikesResource::collection(Like::search($request)->sort($request)->paginate((request('per_page') ?? request('itemsPerPage')) ?? 15));
    }
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), Like::createRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $likes = Like::create($validator->validated());
        return new LikesResource($likes);
    }
    public function show(Request $request, Like $likes)
    {

        return new LikesResource($likes);
    }
    public function update(Request $request, Like $likes)
    {

        $validator = Validator::make($request->all(), Like::updateRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $likes->update($validator->validated());
        return new LikesResource($likes);
    }
    public function destroy(Request $request, Like $likes)
    {
        $likes->delete();
        return new LikesResource($likes);
    }
}
