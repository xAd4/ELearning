<?php

namespace App\Http\Controllers;

use App\Models\QAndQ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QAndQController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(QAndQ::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {

        $validate = $request->validate([
            "course_id" => "required|integer",
            "title" => "required|string|min:10|max:100",
            "description" => "required|string|min:10",
        ]);

        $newQandq = QAndQ::create([
            "user_id" => $request->user()->id,
            "course_id" => $validate["course_id"],
            "title" => $validate["title"],
            "description" => $validate["description"],
        ]);

        return response()->json($newQandq, 201);
    }

    public function show(string $id): JsonResponse
    {
        $qandq = QAndQ::findOrFail($id);
        return response()->json($qandq, 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $qAndQ = QAndQ::findOrFail($id);
        $qAndQ->update($request->all());
        return response()->json($qAndQ->load("responses.user"), 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $qAndQ = QAndQ::firstOrFail($id);
        $qAndQ->delete();
        return response()->json(null, 204);
    }
}
