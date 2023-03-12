<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\JobCategoryRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\ProvinceRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Repositories\EmployeerRepository;
use App\Repositories\UserRepository;
use App\Repositories\JobCategoryRepsitory;
use App\Repositories\CountryRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\CityRepository;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(ProvinceRepositoryInterface::class, ProvinceRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
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
