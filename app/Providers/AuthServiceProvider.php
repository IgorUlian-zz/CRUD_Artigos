<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // COMENTÁRIO: Esta linha conecta o modelo Article com a sua respectiva policy.
        Article::class => ArticlePolicy::class,

        // COMENTÁRIO: Esta é a linha que você precisa adicionar.
        // Ela conecta o modelo User com a nova UserPolicy que criamos.
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
