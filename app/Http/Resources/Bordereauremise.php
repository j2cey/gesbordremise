<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Bordereauremise
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 * @property string $numero_transaction
 * @property string $montant_total
 * @property string $loc
 * @property string $mode_paiement
 * @property integer $bordereauremise_loc_id
 * @property string $titre
 * @property string $localisation_titre
 * @property string $workflow_currentstep_code
 * @property string $workflow_currentstep_titre
 */
class Bordereauremise extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'numero_transaction' => $this->numero_transaction,
            'montant_total' => $this->montant_total,
            //'loc' => (new BordereauremiseLoc($this->whenLoaded('localisation'))),
            //'statut' => $this->bordereauremise_loc_id,
            'mode_paiement' => $this->mode_paiement,
            'titre' => $this->titre,
            'localisation_titre' => $this->localisation_titre,
            'workflow_currentstep_titre' => $this->workflow_currentstep_titre,
            'workflow_currentstep_code' => $this->workflow_currentstep_code,
            'edit_url' => route('bordereauremises.edit', $this->uuid),
            'destroy_url' => route('bordereauremises.destroy', $this->uuid),
        ];
    }
}
