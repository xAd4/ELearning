<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = Section::all();
        return response()->json($sections, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "course_id" => "required|integer",
            "title" => "required|string|min:3|max:255",
            "order" => "required|integer",
        ]);

        $newSection = Section::create([
            "course_id" => $validate["course_id"],
            "title" => $validate["title"],
            "order" => $validate["order"],
        ]);

        return response()->json($newSection, 201);
    }

    public function show(string $id): JsonResponse
    {
        $section = Section::findOrFail($id);
        return response()->json($section, 200);
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            "title" => "sometimes|string|min:3|max:255",
            "order" => "sometimes|integer",
        ]);

        $section = Section::where('id', $id)
            ->whereHas('course', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->firstOrFail();

        $section->update([
            "title" => $validate["title"],
            "order" => $validate["order"],
        ]);

        return response()->json($section, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $section = Section::where('id', $id)
            ->whereHas('course', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->firstOrFail();
        $section->delete();
        return response()->json(null, 204);
    }
}
