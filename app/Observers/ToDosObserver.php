<?php

namespace App\Observers;

use App\Models\ToDos;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ToDosObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the ToDos "created" event.
     */
    public function created(ToDos $toDos): void
    {
        $description = 'Todo item (ID: ' . $toDos->id . ') "' . $toDos->title . '" has been created.';

        $data = [
            'user_id' => $toDos->user_id,
            'type' => ActivityLog::TYPE_CREATE,
            'description' => $description,
        ];

        ActivityLog::create($data);

        // Log a message to the 'activitylog' channel
        Log::channel('activitylog')->info('New todo item is created', [
            'ID' => $toDos->id,
            'User ID' => $toDos->user_id,
            'Title' => $toDos->title,
            'Description' => $toDos->description,
            'Status' => $toDos->status,
            'Time' => $toDos->created_at,
        ]);
    }

    /**
     * Handle the ToDos "updated" event.
     */
    public function updated(ToDos $toDos): void
    {
        $description = 'Todo item (ID: ' . $toDos->id . ') "' . $toDos->title . '" has been updated.';

        $data = [
            'user_id' => $toDos->user_id,
            'type' => ActivityLog::TYPE_UPDATE,
            'description' => $description,
        ];

        ActivityLog::create($data);

        // Log a message to the 'activitylog' channel
        Log::channel('activitylog')->info('Todo item is updated', [
            'ID' => $toDos->id,
            'User ID' => $toDos->user_id,
            'Title' => $toDos->title,
            'Description' => $toDos->description,
            'Status' => $toDos->status,
            'Time' => $toDos->created_at,
        ]);
    }

    /**
     * Handle the ToDos "deleted" event.
     */
    public function deleted(ToDos $toDos): void
    {
        $description = 'Todo item (ID: ' . $toDos->id . ') "' . $toDos->title . '" has been deleted.';

        $data = [
            'user_id' => $toDos->user_id,
            'type' => ActivityLog::TYPE_DELETE,
            'description' => $description,
        ];

        ActivityLog::create($data);

        // Log a message to the 'activitylog' channel
        Log::channel('activitylog')->info('Todo item is deleted', [
            'ID' => $toDos->id,
            'User ID' => $toDos->user_id,
            'Title' => $toDos->title,
            'Description' => $toDos->description,
            'Status' => $toDos->status,
            'Time' => $toDos->created_at,
        ]);
    }

    /**
     * Handle the ToDos "restored" event.
     */
    public function restored(ToDos $toDos): void
    {
        //
    }

    /**
     * Handle the ToDos "force deleted" event.
     */
    public function forceDeleted(ToDos $toDos): void
    {
        //
    }
}
