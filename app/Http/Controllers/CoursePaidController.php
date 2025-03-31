<?php

namespace App\Http\Controllers;

use App\Models\CoursePaid;
use Illuminate\Http\Request;

class CoursePaidController extends Controller
{
    public function index()
    {
        return CoursePaid::all();
    }

    public function store(Request $request)
    {
        return CoursePaid::create($request->all());
    }

    public function show(CoursePaid $coursePaid)
    {
        return $coursePaid;
    }

    public function update(Request $request, CoursePaid $coursePaid)
    {
        $coursePaid->update($request->all());
        return $coursePaid;
    }

    public function destroy(CoursePaid $coursePaid)
    {
        $coursePaid->delete();
        return response()->noContent();
    }
}
