<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\TsumiageItem' => 'App\Policies\TsumiageItemPolicy',
        'App\Models\Tsumiage' => 'App\Policies\TsumiagePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 一般ユーザーの登録・ログイン画面にアクセス可能
        Gate::define('manage_member', function (User $user) {
            return $user->role_id === 1; // 管理者
        });
    }
}
