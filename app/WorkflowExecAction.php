<?php

namespace App;

use Illuminate\Support\Carbon;
use PHPUnit\Util\Json;

/**
 * Class WorkflowExecAction
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|null $motif_rejet
 * @property Json $report
 *
 * @property integer|null $workflow_exec_id
 * @property integer|null $workflow_action_id
 * @property integer|null $workflow_status_id
 *
 * @property string|null $model_type
 * @property string|null $model_field
 * @property integer|null $model_id
 * @property string|null $rawvalue
 * @property string|null $setvalue
 *
 * @property boolean $current
 * @property integer|null $prev_exec_id
 * @property integer|null $next_exec_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecAction extends BaseModel
{
    protected $guarded = [];

    public function workflowexec() {
        return $this->belongsTo('App\WorkflowExec', 'workflow_exec_id');
    }

    public function action() {
        return $this->belongsTo('App\WorkflowAction', 'workflow_action_id');
    }

    public function workflowstatus() {
        return $this->belongsTo('App\WorkflowStatus', 'workflow_status_id');
    }

    public function prevexec() {
        return $this->belongsTo('App\WorkflowExecAction', 'prev_exec_id');
    }

    public function nextexec() {
        return $this->belongsTo('App\WorkflowExecAction', 'next_exec_id');
    }
}
