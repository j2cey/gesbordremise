<?php

namespace App;

use App\Traits\Workflow\HasWorkflowsOrActions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Bordereauremise
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $fichier_source
 * @property Carbon $date_remise
 * @property string $numero_transaction
 * @property string $localisation
 * @property string $changement_dernier_tarift
 * @property string $montant_total
 *
 * @property Carbon $date_depot_agence
 * @property integer $montant_depose_agence
 * @property string $scan_bordereau
 * @property string $commentaire_agence
 *
 * @property string $localisation_titre
 * @property string $modepaiement_titre
 * @property string $bordereauremise_type_titre
 * @property string $bordereauremise_type_code
 * @property string $workflow_currentstep_code
 * @property string $workflow_currentstep_titre
 *
 * @property integer|null $bordereauremise_loc_id
 * @property integer|null $bordereauremise_modepaie_id
 * @property integer|null $bordereauremise_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Bordereauremise extends BaseModel
{
    use HasWorkflowsOrActions;

    protected $guarded = [];
    protected $table = 'bordereauremises';
    //protected $with = ['localisation'];

    #region Eloquent Relationships

    public function localisation() {
        return $this->belongsTo(BordereauremiseLoc::class, 'bordereauremise_loc_id');
    }

    public function modepaiement() {
        return $this->belongsTo(BordereauremiseModepaie::class, 'bordereauremise_modepaie_id');
    }

    public function type() {
        return $this->belongsTo(BordereauremiseType::class, 'bordereauremise_type_id');
    }

    public function lignes() {
        return $this->hasMany('App\BordereauremiseLigne','bordereauremise_id');
    }

    public function workflowexecs() {
        return $this->hasMany('App\WorkflowExec', 'model_id')
            ->where('model_type', 'App\Bordereauremise');
        //->whereNotNull('current_step_id');
    }

    public function workflowexec() {
        return $this->hasOne('App\WorkflowExec', 'model_id')
            ->where('model_type', 'App\Bordereauremise')
            ->latest();
        //->whereNotNull('current_step_id');
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après création
        self::created(function($model){

            /*$workflows = $model->workflows();
            if ($workflows) {
                foreach ($workflows as $workflow) {
                    $workflow->execworkflow();
                }
            }*/
            // Launch workflows
            $model->launchWorkflows();

            // Launch actions
            $model->launchWorkflowActions();
        });
    }
}
