<?php

namespace App;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

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
 * @property string $code
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

    public function profile() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function actions() {
        return $this->hasMany('App\WorkflowAction', 'workflow_step_id');
    }

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => 'required',
            'profile' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'actions' => 'required',
        ]);
    }

    #endregion

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }
}
