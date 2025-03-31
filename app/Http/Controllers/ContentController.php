<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(): JsonResponse
    {
        $contents = Content::all();
        return response()->json($contents, 200);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            "section_id" => "required|integer",
            "title" => "required|string|min:10|max:255",
            "file_path" => "required|file|mimes:pdf,mp4,png,jpg,jpeg|mimetypes:application/pdf,video/mp4,image/png,image/jpeg",
            "order" => "required|integer",
        ]);

        $newContent = Content::create([
            "section_id" => $validate["section_id"],
            "title" => $validate["title"],
            "file_path" => $validate["file_path"]->store("courses/content", "public"),
            "order" => $validate["order"],
        ]);

        return response()->json($newContent, 201);
    }

    public function show(string $id): JsonResponse
    {
        $content = Content::findOrFail($id);
        return response()->json($content, 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $content = Content::findOrFail($id);

        $validate = $request->validate([
            "title" => "sometimes|string|min:3|max:255",
            "file_path" => "sometimes|file|mimes:pdf,mp4,png,jpg,jpeg",
            "order" => "sometimes|integer",
        ]);

        if ($request->hasFile("file_path")) {
            Storage::disk("public")->delete($content->file_path);
            $validate["file_path"] = $request->file("file_path")->store("courses/content", "public");
        } else {
            unset($validate["file_path"]);
        }

        $content->update($validate);
        $content->refresh();

        return response()->json($content, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return response()->json(null, 204);
    }
}
