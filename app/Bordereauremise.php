<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
 * @property string $scan_bordereau
 * @property Carbon $date_depot_agence
 * @property Carbon $date_effectif
 * @property Carbon $date_valeur
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Bordereauremise extends BaseModel
{
    protected $guarded = [];

    public function workflow() {
        $workflow_id = DB::table('model_has_workflow')
            ->where('model_type', 'App\Bordereauremise')
            ->value('workflow_id');

        if ($workflow_id) {
            return Workflow::where('id', $workflow_id)->first();
        } else {
            return null;
        }
    }

    public function execaction() {
        return $this->hasMany('App\WorkflowExecAction', 'model_id')
            ->where('model_type', 'App\Bordereauremise')
            ->where('current', 1);
    }

    public static function boot(){
        parent::boot();

        // Après création
        self::created(function($model){
            $workflow = $model->workflow();
            if ($workflow) {
                $workflow->exec();
            }
        });
    }
}
