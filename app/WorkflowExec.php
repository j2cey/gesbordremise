<?php

namespace App;

use Illuminate\Support\Carbon;
use PHPUnit\Util\Json;

/**
 * Class WorkflowExec
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $prev_step
 * @property integer $curr_step
 * @property integer $next_step
 * @property Json $report
 *
 * @property integer|null $workflow_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExec extends BaseModel
{
    protected $guarded = [];
}
