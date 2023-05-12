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
        $description = '(ID: ' . $toDos->id . ') Todo item "' . $toDos->title . '" has been created.';

        $data = [
            'user_id' => $toDos->user_id,
            'todo_id' => $toDos->id,
            'type' => ActivityLog::TYPE_CREATE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDos "updated" event.
     */
    public function updated(ToDos $toDos): void
    {
        if (!$toDos->wasChanged('deleted_at')) {
            $description = '(ID: ' . $toDos->id . ') Todo item "' . $toDos->title . '" has been updated.';

            $data = [
                'user_id' => $toDos->user_id,
                'todo_id' => $toDos->id,
                'type' => ActivityLog::TYPE_UPDATE,
                'description' => $description,
            ];

            ActivityLog::create($data);
        }
    }

    /**
     * Handle the ToDos "deleted" event.
     */
    public function deleted(ToDos $toDos): void
    {
        $description = '(ID: ' . $toDos->id . ') Todo item "' . $toDos->title . '" has been deleted.';

        $data = [
            'user_id' => $toDos->user_id,
            'todo_id' => $toDos->id,
            'type' => ActivityLog::TYPE_DELETE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDos "restored" event.
     */
    public function restored(ToDos $toDos): void
    {
        $description = '(ID: ' . $toDos->id . ') Todo item "' . $toDos->title . '" has been restored.';

        $data = [
            'user_id' => $toDos->user_id,
            'todo_id' => $toDos->id,
            'type' => ActivityLog::TYPE_RESTORE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDos "force deleted" event.
     */
    public function forceDeleted(ToDos $toDos): void
    {
        //
    }
}
