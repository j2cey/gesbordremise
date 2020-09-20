<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
}
