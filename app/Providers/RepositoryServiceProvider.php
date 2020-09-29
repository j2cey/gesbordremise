<?php

namespace App\Providers;

use App\Repositories\Contracts\IBordereauremiseRepositoryContract;
use App\Repositories\Eloquent\BordereauremiseRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\IProductRepositoryContract;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(IProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(IBordereauremiseRepositoryContract::class, BordereauremiseRepository::class);
    }
}
