<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;
use Spatie\Permission\Models\Role;

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
 * @property integer|null $current_step_id
 * @property integer|null $workflow_id
 * @property string $model_type
 * @property integer $model_id
 *
 * @property string|null $motif_rejet
 * @property Json $report
 * @property integer|null $workflow_status_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExec extends BaseModel
{
    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo('App\Workflow','workflow_id');
    }

    public function currentstep() {
        // Auth::user()->id
        return $this->belongsTo('App\WorkflowStep','current_step_id');
    }

    public function currentstepuser() {
        /*$userprofile = Role::whereIn('id',
            DB::table('model_has_roles')
                ->where('model_type', 'App\User')
                ->where('model_id', Auth::user()->id)
            ->pluck('role_id')->toArray()
        )->first();*/
        //$user = User::where('id', Auth::user()->id)->first();

        return $this->belongsTo('App\WorkflowStep','current_step_id');
    }

    public function workflowstatus() {
        return $this->belongsTo('App\WorkflowStatus','workflow_status_id');
    }

    #endregion
}
