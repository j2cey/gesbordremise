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
 * @property string $localisation
 * @property string $mode_paiement
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
            'localisation' => $this->localisation,
            'mode_paiement' => $this->mode_paiement,
            'edit_url' => route('bordereauremises.edit', $this->uuid),
            'destroy_url' => route('bordereauremises.destroy', $this->uuid),
        ];
    }
}
