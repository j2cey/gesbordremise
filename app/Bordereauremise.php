<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
 * @property string $changement_dernier_tarif
 * @property string $classe_paiement
 * @property string $mode_paiement
 * @property string $montant_total
 *
 * @property Carbon $date_depot
 * @property integer $montant_depose_agence
 * @property string $scan_bordereau
 * @property string $commentaire_agence
 *
 * @property Carbon $date_valeur
 * @property integer $montant_depose_finance
 * @property string $commentaire_finance
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Bordereauremise extends BaseModel
{
    protected $guarded = [];

    #region Eloquent Relationships

    /**
     * Le(s) Workflow(s) rattaché(s) a ce type de modèle le cas échéant
     * @return Collection|null
     */
    public function workflows() {
        /*return $this->hasMany('App\Workflow', 'model_id')
            ->where('model_type', 'App\Bordereauremise');*/
        $workflows = Workflow::where('model_type', 'App\Bordereauremise')
            ->get();

        if ($workflows) {
            return $workflows;
        } else {
            return null;
        }
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

    /**
     * L'instance d'exécution du workflow rattaché, le cas échéant.
     * @return WorkflowExec|\Illuminate\Database\Eloquent\Collection|HasMany
     */
    public function workflowexecs_old() {

        $user = User::where('id', Auth::user()->id())->first();

        //return $this->workflowexecs_all;

        $workflowexecs = array();
        foreach ($this->workflowexecs_all as $exec) {
            if ($user->hasAnyRole([$exec->currentstep->profile->name, 'Admin'])) {
                $workflowexecs[] = $exec;
            }
        }
        return \Illuminate\Database\Eloquent\Collection::make($workflowexecs);
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Après création
        self::created(function($model){
            $workflows = $model->workflows();
            if ($workflows) {
                foreach ($workflows as $workflow) {
                    $workflow->exec();
                }
            }
        });
    }
}
