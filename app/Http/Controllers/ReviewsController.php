<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index(): JsonResponse
    {
        $reviews = Reviews::all();
        return response()->json($reviews, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "course_id" => "required|integer",
            "rating" => "required|numeric|min:1|max:5",
            "description" => "required|string|min:10|max:255",
        ]);

        $newReview = Reviews::create([
            "course_id" => $validate["course_id"],
            "user_id" => $request->user()->id,
            "rating" => $validate["rating"],
            "description" => $validate["description"],
        ]);

        return response()->json($newReview, 201);
    }

    public function show(string $id): JsonResponse
    {
        $review = Reviews::findOrFail($id);
        return response()->json($review, 200);
    }
}
