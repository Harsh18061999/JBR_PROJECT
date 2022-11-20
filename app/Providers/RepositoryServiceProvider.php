<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\JobCategoryRepositoryInterface;
use App\Repositories\EmployeerRepository;
use App\Repositories\JobCategoryRepsitory;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeerRepository::class);
        $this->app->bind(JobCategoryRepositoryInterface::class, JobCategoryRepsitory::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepsitory::class);
        $this->app->bind(JobRequestRepositoryInterface::class, JobRequesttRepsitory::class);
        $this->app->bind(DataEntryRepositoryInterface::class, DataEntryPointRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
