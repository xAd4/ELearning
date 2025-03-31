<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $categoriesAvailable = Category::where("is_available", true)->get();
            $categoriesUnavailable = Category::where("is_available", false)->get();
            return response()->json([
                "categoriesAvailable" => $categoriesAvailable,
                "categoriesUnavailable" => $categoriesUnavailable,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "name" => "required|string|min:3|max:100|unique:categories,name",
        ]);

        try {
            $newCategory = Category::create([
                "name" => $validate["name"],
            ]);

            return response()->json([
                $newCategory,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                $category,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validate = $request->validate([
            "name" => "sometimes|string|min:3|max:100|unique:categories,name,$id",
        ]);
        try {
            $category = Category::findOrFail($id);
            $category->update([
                "name" => $validate["name"],
            ]);

            return response()->json([
                $category,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->update(["is_available" => false]);
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
