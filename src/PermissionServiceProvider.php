<?php

namespace Udhuong\Permission;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Udhuong\Permission\Domain\Contracts\AuthRepository;
use Udhuong\Permission\Infrastructure\Repositories\AuthRepositoryImpl;
use Udhuong\Permission\Presentation\Consoles\AssignPermissionCommand;
use Udhuong\Permission\Presentation\Consoles\MakePermissionCommand;
use Udhuong\Permission\Presentation\Middlewares\VerifyPermission;

class PermissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            MakePermissionCommand::class,
            AssignPermissionCommand::class,
        ]);
    }

    public function boot(): void
    {
        $this->registerRepository();

        // Đăng ký middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('verify.permission', VerifyPermission::class);

        // Đăng ký route
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    private function registerRepository(): void
    {
        $this->app->bind(AuthRepository::class, AuthRepositoryImpl::class);
    }
}
