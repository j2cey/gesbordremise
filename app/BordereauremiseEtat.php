<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BordereauremiseEtat
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
 * @property string $code
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BordereauremiseEtat extends BaseModel
{
    protected $guarded = [];

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }
}
