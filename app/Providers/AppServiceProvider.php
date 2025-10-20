<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\SubjectRegistrationRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\SubjectRegistrationRepository;
use App\Repositories\SubjectRepository;
use App\Services\BaseService;
use App\Services\Interfaces\BaseServiceInterface;
use App\Services\Interfaces\SubjectRegistrationServiceInterface;
use App\Services\Interfaces\SubjectServiceInterface;
use App\Services\SubjectRegistrationService;
use App\Services\SubjectService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);

        $this->app->bind(BaseServiceInterface::class, BaseService::class);
        $this->app->bind(SubjectServiceInterface::class, SubjectService::class);

        $this->app->bind(SubjectRegistrationRepositoryInterface::class, SubjectRegistrationRepository::class);
        $this->app->bind(SubjectRegistrationServiceInterface::class, SubjectRegistrationService::class);

        // Đăng ký toastr service đơn giản
        $this->app->singleton('toastr', function ($app) {
            return new class {
                public function success($message) {
                    session()->flash('toastr', ['type' => 'success', 'message' => $message]);
                }
                public function error($message) {
                    session()->flash('toastr', ['type' => 'error', 'message' => $message]);
                }
                public function warning($message) {
                    session()->flash('toastr', ['type' => 'warning', 'message' => $message]);
                }
                public function info($message) {
                    session()->flash('toastr', ['type' => 'info', 'message' => $message]);
                }
            };
        });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Ngăn chặn migrate:fresh trên production
    if (app()->environment('production')) {
        Artisan::command('migrate:fresh', function () {
            $this->error('❌ migrate:fresh is disabled in production!');
            return 1;
        });
        
        Artisan::command('migrate:fresh --seed', function () {
            $this->error('❌ migrate:fresh is disabled in production!');
            return 1;
        });
    }
}
}
