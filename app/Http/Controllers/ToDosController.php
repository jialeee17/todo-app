<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ToDos;

class ToDosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todos::all();

        return Inertia::render('ToDo/Index', [
            'todos' => $todos
        ]);
    }

        /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ToDo/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'todos.*.title' => 'required|string',
            'todos.*.description' => 'nullable|string'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->todos()->createMany($request->todos);

        return to_route('todos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todos::findOrFail($id);

        return Inertia::render('ToDo/View', [
            'todo' => $todo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todos::findOrFail($id);

        return Inertia::render('ToDo/Edit', [
            'todo' => $todo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        $todo = Todos::findOrFail($id);

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return to_route('todos.show', ['todo' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todos::findOrFail($id);
        $todo->delete();

        return to_route('todos.index');
    }
}
