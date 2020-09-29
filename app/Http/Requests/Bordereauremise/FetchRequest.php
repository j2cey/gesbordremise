<?php

namespace App\Http\Requests\Bordereauremise;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest  implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields(): array
    {
        return ['numero_transaction', 'localisation'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField(): string
    {
        return 'numero_transaction';
    }
}
