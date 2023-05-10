<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Models\ToDos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                throw new Exception('User not found!');
            }

            $todos = Todos::where('user_id', $user->id)->get();

            return Inertia::render('ToDo/Index', [
                'todos' => $todos
            ]);
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return Inertia::render('ToDo/Create');
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
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

        try {
            $user = Auth::user();

            if(!$user) {
                throw new Exception('User not found!');
            }

            $user->todos()->createMany($request->todos);

            return to_route('todos.index');
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $todo = Todos::findOrFail($id);

            return Inertia::render('ToDo/View', [
                'todo' => $todo
            ]);
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $todo = Todos::findOrFail($id);

            return Inertia::render('ToDo/Edit', [
                'todo' => $todo
            ]);
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
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

        try {
            $todo = Todos::findOrFail($id);
            $todo->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return to_route('todos.show', ['todo' => $id]);
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $todo = Todos::findOrFail($id);
            $todo->delete();

            return to_route('todos.index');
        } catch (Exception $e) {
            return Inertia::render('Errors', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
