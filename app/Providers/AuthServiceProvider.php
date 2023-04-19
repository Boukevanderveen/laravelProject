<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Article::class => ArticlePolicy::class,
        Project::class => CategoryPolicy::class,
        Project::class => ProjectPolicy::class,
        Role::class => RolePolicy::class,
        Product::class => ProductPolicy::class,
        ProductCategoryPolicy::class => ProductCategoryPolicy::class,
        Order::class => Order::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
