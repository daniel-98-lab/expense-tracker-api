<?php

namespace App\Providers;

use App\Application\UseCases\Category\CreateCategory;
use App\Application\UseCases\Category\DeleteCategory;
use App\Application\UseCases\Category\GetAllCategory;
use App\Application\UseCases\Category\GetCategory;
use App\Application\UseCases\Category\UpdateCategory;
use App\Domain\Interfaces\CategoryRepositoryInterface;
use App\Infrastructure\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->singleton(CreateCategory::class, fn($app) => new CreateCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(DeleteCategory::class, fn($app) => new DeleteCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(GetCategory::class, fn($app) => new GetCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(GetAllCategory::class, fn($app) => new GetAllCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(UpdateCategory::class, fn($app) => new UpdateCategory($app->make(CategoryRepositoryInterface::class)));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
