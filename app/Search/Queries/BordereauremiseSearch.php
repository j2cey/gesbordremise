<?php

namespace App\Search\Queries;

use App\Bordereauremise;
use Illuminate\Database\Eloquent\Builder;

class BordereauremiseSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query(): Builder
    {
        $query = Bordereauremise::query();

        if ($this->params->search->hasFilter()) {
            $query
                ->where('numero_transaction', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('localisation', 'like', '%'.$this->params->search->search.'%');
        }

        return $query;
    }
}
