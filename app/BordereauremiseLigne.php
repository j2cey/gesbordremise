<?php

namespace App;

use App\Traits\Workflow\HasWorkflowsOrActions;
use Illuminate\Support\Carbon;

/**
 * Class BordereauremiseLigne
 * @package App
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $bordereauremise_id
 * @property string|null $reference
 * @property string|null $classe_paiement
 *
 * @property Carbon $date_valeur_finance
 * @property integer|null $montant_depose_finance
 * @property string|null $commentaire_finance
 *
 * @property bool $rejet_finances
 * @property string|null $motif_rejet_finances
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BordereauremiseLigne extends BaseModel
{
    use HasWorkflowsOrActions;
    protected $guarded = [];

    public function bordereau() {
        return $this->belongsTo(Bordereauremise::class, 'bordereauremise_id');
    }

    public static function boot(){
        parent::boot();

        // Après création
        self::created(function($model){

            // Launch workflows
            $model->launchWorkflows();

            // Launch actions
            $model->launchWorkflowActions();
        });

        // Avant enregistrement
        self::saving(function($model){
            // Formaliser le rejet (le cas échéant)
           if ($model->rejet_finances) {
               // on met le montant à zéro
               $model->montant_depose_finance = 0;
               // on récupère la date du jour
               $model->date_valeur_finance = Carbon::now();
           }
        });
    }
}
