<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoreCenterController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ToDo/RestoreCenter');
    }

    public function getTrashedTodoData(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.

        // Get the total number of records, regardless of pagination or filtering.
        $todosNotFiltered = Todo::count();

        $todos = Todo::onlyTrashed()->with('user')
                    ->where('user_id', Auth::id())
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
        // NOTE: Restoring collection that has more than 1 item inside (e.g. Retrieve using 'get()') is like "mass operation". This will not dispatch any model events for the models that are restored:
        Todo::withTrashed()->where('id', $id)
                        ->first()
                        ->restore();

        return redirect()->back()->with('message', 'Todo restored!');
    }
}
