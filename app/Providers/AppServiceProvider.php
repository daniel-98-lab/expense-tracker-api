<?php

namespace App\Providers;

use App\Application\UseCases\Category\CreateCategory;
use App\Application\UseCases\Category\DeleteCategory;
use App\Application\UseCases\Category\GetAllCategory;
use App\Application\UseCases\Category\GetCategory;
use App\Application\UseCases\Category\UpdateCategory;
use App\Application\UseCases\Expense\CreateExpense;
use App\Application\UseCases\Expense\DeleteExpense;
use App\Application\UseCases\Expense\GetExpense;
use App\Application\UseCases\Expense\GetExpensesByFilters;
use App\Application\UseCases\Expense\UpdateExpense;
use App\Application\UseCases\User\GetUser;
use App\Application\UseCases\User\LoginUser;
use App\Application\UseCases\User\LogoutUser;
use App\Application\UseCases\User\RefreshTokenUser;
use App\Domain\Interfaces\CategoryRepositoryInterface;
use App\Domain\Interfaces\ExpenseRepositoryInterface;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\ExpenseRepository;
use App\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // CATEGORY
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(CreateCategory::class, fn($app) => new CreateCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(DeleteCategory::class, fn($app) => new DeleteCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(GetCategory::class, fn($app) => new GetCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(GetAllCategory::class, fn($app) => new GetAllCategory($app->make(CategoryRepositoryInterface::class)));
        $this->app->singleton(UpdateCategory::class, fn($app) => new UpdateCategory($app->make(CategoryRepositoryInterface::class)));
        
        // Expense
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->singleton(CreateExpense::class, fn($app) => new CreateExpense($app->make(ExpenseRepositoryInterface::class)));
        $this->app->singleton(DeleteExpense::class, fn($app) => new DeleteExpense($app->make(ExpenseRepositoryInterface::class)));
        $this->app->singleton(GetExpense::class, fn($app) => new GetExpense($app->make(ExpenseRepositoryInterface::class)));
        $this->app->singleton(GetExpensesByFilters::class, fn($app) => new GetExpensesByFilters($app->make(ExpenseRepositoryInterface::class)));
        $this->app->singleton(UpdateExpense::class, fn($app) => new UpdateExpense($app->make(ExpenseRepositoryInterface::class)));

        // USER
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(GetUser::class, fn($app) => new GetUser($app->make(UserRepositoryInterface::class)));
        $this->app->singleton(LoginUser::class, fn($app) => new LoginUser($app->make(UserRepositoryInterface::class)));
        $this->app->singleton(LogoutUser::class, fn($app) => new LogoutUser($app->make(UserRepositoryInterface::class)));
        $this->app->singleton(RefreshTokenUser::class, fn($app) => new RefreshTokenUser($app->make(UserRepositoryInterface::class)));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
