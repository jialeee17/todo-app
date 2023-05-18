<?php

namespace App\Observers;

use App\Models\ToDo;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ToDoObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the ToDo "created" event.
     */
    public function created(ToDo $toDo): void
    {
        $description = '(ID: ' . $toDo->id . ') Todo item "' . $toDo->title . '" has been created.';

        $data = [
            'user_id' => $toDo->user_id,
            'todo_id' => $toDo->id,
            'type' => ActivityLog::TYPE_CREATE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDo "updated" event.
     */
    public function updated(ToDo $toDo): void
    {
        if (!$toDo->wasChanged('deleted_at')) {
            $description = '(ID: ' . $toDo->id . ') Todo item "' . $toDo->title . '" has been updated.';

            $data = [
                'user_id' => $toDo->user_id,
                'todo_id' => $toDo->id,
                'type' => ActivityLog::TYPE_UPDATE,
                'description' => $description,
            ];

            ActivityLog::create($data);
        }
    }

    /**
     * Handle the ToDo "deleted" event.
     */
    public function deleted(ToDo $toDo): void
    {
        $description = '(ID: ' . $toDo->id . ') Todo item "' . $toDo->title . '" has been deleted.';

        $data = [
            'user_id' => $toDo->user_id,
            'todo_id' => $toDo->id,
            'type' => ActivityLog::TYPE_DELETE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDo "restored" event.
     */
    public function restored(ToDo $toDo): void
    {
        $description = '(ID: ' . $toDo->id . ') Todo item "' . $toDo->title . '" has been restored.';

        $data = [
            'user_id' => $toDo->user_id,
            'todo_id' => $toDo->id,
            'type' => ActivityLog::TYPE_RESTORE,
            'description' => $description,
        ];

        ActivityLog::create($data);
    }

    /**
     * Handle the ToDo "force deleted" event.
     */
    public function forceDeleted(ToDo $toDo): void
    {
        //
    }
}
