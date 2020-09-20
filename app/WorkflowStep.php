<?php

namespace App;

use Illuminate\Support\Carbon;

/**
 * Class WorkflowStep
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 * @property integer $posi
 * @property string|null $description
 *
 * @property integer|null $workflow_id
 * @property integer|null $role_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowStep extends BaseModel
{
    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo('App\Workflow');
    }

    public function actorprofile() {
        return $this->belongsTo(Spatie\Permission\Models\Role::class, 'role_id');
    }

    #endregion
}
