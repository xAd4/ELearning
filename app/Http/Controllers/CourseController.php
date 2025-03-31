<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::with(['category', 'user', 'sections', 'reviews', 'qandq'])->get();

        return response()->json([
            "ok" => true,
            "courses" => $courses
        ]);
    }

    public function store(Request $request): JsonResponse
    {

        $validate = $request->validate([
            "category_id" => "required|integer",
            // "user_id",
            "img" => "required|file|mimes:png,jpg,jpeg|max:2048",
            "title" => "required|string|min:10|max:100",
            "description" => "required|string|min:10",
            "price" => "required|numeric|min:0",
        ]);



        $course = Course::create([
            "category_id" => $validate["category_id"],
            "user_id" => $request->user()->id,
            "img" => $validate["img"]->store("courses/images", "public"),
            "title" => $validate["title"],
            "description" => $validate["description"],
            "price" => $validate["price"],
        ]);

        return response()->json([
            "ok" => true,
            "message" => "Curso creado exitosamente",
            "course" => $course->load(['category', 'user'])
        ], 201);
    }

    public function show(string $id): JsonResponse
    {

        $course = Course::findOrFail($id);

        return response()->json([
            "ok" => true,
            "course" => $course->load([
                'category',
                'user',
                'sections.contents',
                'reviews.user',
                'qandq.responses.user'
            ])
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $course = Course::findOrFail($id);

        $validate = $request->validate([
            "category_id" => "required|integer",
            "img" => "required|file|mimes:png,jpg,jpeg|max:2048",
            "title" => "required|string|min:10|max:100",
            "description" => "required|string|min:10",
            "price" => "required|numeric|min:0",
        ]);

        try {

            if ($request->hasFile('img')) {
                Storage::disk('public')->delete($course->img);
                $validate['img'] = $request->file('img')->store("courses/images", "public");
            }

            $course->update($validate);
            $course->refresh()->load(["category", "user"]);

            return response()->json([
                "ok" => true,
                "message" => "course updated",
                $course,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            "ok" => true,
            "message" => "Curso eliminado"
        ], 204);
    }
}
