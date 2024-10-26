<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Challenge;
use App\Models\DailyTask;
use App\Policies\ChallengePolicy;
use App\Policies\DailyTaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Challenge::class => ChallengePolicy::class,
        DailyTask::class => DailyTaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
