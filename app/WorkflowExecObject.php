<?php

namespace App;

use Illuminate\Support\Carbon;
use PHPUnit\Util\Json;

/**
 * Class WorkflowExecObject
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property Json $report
 *
 * @property integer|null $workflow_exec_id
 * @property integer|null $workflow_action_id
 * @property integer|null $workflow_status_id
 * @property integer|null $model_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecObject extends BaseModel
{
    protected $guarded = [];
}
