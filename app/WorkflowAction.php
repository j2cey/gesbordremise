<?php

namespace App;

use Illuminate\Support\Carbon;

/**
 * Class WorkflowAction
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
 * @property integer|null $workflow_action_type_id
 * @property integer|null $workflow_step_id
 * @property integer|null $workflow_object_field_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowAction extends BaseModel
{
    protected $guarded = [];

    public function step() {
        return $this->belongsTo('App\WorkflowStep', 'workflow_step_id');
    }

    public function actiontype() {
        return $this->belongsTo('App\WorkflowActionType', 'workflow_action_type_id');
    }

    public function objectfield() {
        return $this->belongsTo('App\WorkflowObject', 'workflow_object_field_id');
    }
}
