<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function index(): JsonResponse
    {
        $responses = Response::all();
        return response()->json($responses, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "qandq_id" => "required|integer",
            "description" => "required|string|min:10|",
        ]);

        $newResponse = Response::create([
            "qandq_id" => $validate["qandq_id"],
            "user_id" => $request->user()->id,
            "description" => $validate["description"],
        ]);

        return response()->json($newResponse, 201);
    }


    public function update(Request $request, string $id): JsonResponse
    {
        $validate = $request->validate([
            "qandq_id" => "required|integer",
            "description" => "required|string|min:10|",
        ]);

        $response = Response::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $response->update($validate);

        return response()->json($response, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $response = Response::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();
        $response->delete();
        return response()->json(null, 204);
    }
}
