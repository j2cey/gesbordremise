<?php

namespace App;

use Illuminate\Support\Carbon;

/**
 * Class Workflow
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
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Workflow extends BaseModel
{
    protected $guarded = [];

    #region Eloquent Relationships

    public function steps() {
        return $this->hasMany('App\WorkflowStep');
    }

    #endregion
}
