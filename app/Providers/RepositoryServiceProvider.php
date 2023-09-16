<?php

namespace App\Providers;

use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Respository\CartRepository;
use App\Repositories\Respository\CouponRepository;
use App\Repositories\Respository\OrderRepository;
use App\Repositories\Respository\OtpVerificationRepository;
use App\Repositories\Respository\ProductRepository;
use App\Repositories\Respository\UserAddressRepository;
use App\Repositories\Respository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );
        $this->app->bind(
            UserAddressRepositoryInterface::class,
            UserAddressRepository::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );
        $this->app->bind(
            OtpVerificationRepositoryInterface::class,
            OtpVerificationRepository::class
        );
    }
}
