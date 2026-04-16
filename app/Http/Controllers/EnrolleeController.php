<?php

namespace App\Http\Controllers;

use App\Models\Enrollee;
use App\Http\Requests\StoreEnrolleeRequest;
use App\Http\Requests\UpdateEnrolleeRequest;

class EnrolleeController extends Controller
{
    public function index()
    {
        $enrollees = Enrollee::orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('enrollees'));
    }

    public function store(StoreEnrolleeRequest $request)
    {
        Enrollee::create($request->only(['student_id', 'name', 'course', 'year', 'block']));
        return redirect()->route('dashboard')->with('success', 'Enrollee added!');
    }

    public function update(UpdateEnrolleeRequest $request, Enrollee $enrollee)
    {
        $enrollee->update($request->only(['name', 'course', 'year', 'block']));
        return redirect()->route('dashboard')->with('success', 'Enrollee updated!');
    }

    public function destroy(Enrollee $enrollee)
    {
        $enrollee->delete();
        return redirect()->route('dashboard')->with('success', 'Enrollee deleted.');
    }
}