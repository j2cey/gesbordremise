<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base\BaseTrait;

class BaseModel extends Model
{
    use BaseTrait;

    public function getRouteKeyName() { return 'uuid'; }

    #region Eloquent Relationships

    public function status() {
        return $this->belongsTo('App\Status');
    }

    #endregion

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    #endregion
}
