<?php

namespace App\Models;

use App\Models\User;
use App\Models\ToDos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'todo_id',
        'type',
        'description',
        'performed_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Types (Events)
    const TYPE_CREATE = 'CREATE';
    const TYPE_UPDATE = 'UPDATE';
    const TYPE_DELETE = 'DELETE';

    public static $types = [
        self::TYPE_CREATE,
        self::TYPE_UPDATE,
        self::TYPE_DELETE
    ];

    /* -------------------------------------------------------------------------- */
    /*                                Relationship                                */
    /* -------------------------------------------------------------------------- */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todos()
    {
        return $this->belongsTo(ToDos::class, 'todo_id');
    }
}
