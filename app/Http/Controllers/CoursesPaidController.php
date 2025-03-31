<?php

namespace App\Http\Controllers;

use App\Models\CoursesPaid;
use Illuminate\Http\Request;

class CoursesPaidController extends Controller
{
    public function index()
    {
        return CoursesPaid::all();
    }

    public function store(Request $request)
    {
        return CoursesPaid::create($request->all());
    }

    public function show(CoursesPaid $coursesPaid)
    {
        return $coursesPaid->load('coursePaid');
    }

    public function update(Request $request, CoursesPaid $coursesPaid)
    {
        $coursesPaid->update($request->all());
        return $coursesPaid;
    }

    public function destroy(CoursesPaid $coursesPaid)
    {
        $coursesPaid->delete();
        return response()->noContent();
    }
}
