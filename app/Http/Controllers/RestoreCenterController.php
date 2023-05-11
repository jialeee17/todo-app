<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ToDos;

class RestoreCenterController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ToDo/RestoreCenter');
    }

    public function getTrashedTodosData(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.

        // Get the total number of records, regardless of pagination or filtering.
        $todosNotFiltered = Todos::count();

        $todos = Todos::onlyTrashed()->with('user')
                    ->orderBy('deleted_at', 'DESC')
                    ->paginate($limit, ['*'], 'page', $page);

        $result = [
            'total' => $todos->total(),
            'totalNotFiltered' => $todosNotFiltered,
            'rows' => $todos->items(),
        ];

        return response()->json([
            'success' => true,
            'data' => $result,
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        Todos::withTrashed()->where('id', $id)
                        ->restore();

        return redirect()->back()->with('message', 'Todo restored!');
    }
}
