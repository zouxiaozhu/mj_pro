<?php

namespace App\Providers;

use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberCreditInterface;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberInterface;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberSettingInterface;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberSMSInterface;
use App\Http\Controllers\Api\Member\Repositories\Member;
use App\Http\Controllers\Api\Member\Repositories\MemberCredit;
use App\Http\Controllers\Api\Member\Repositories\MemberSetting;
use App\Http\Controllers\Api\Member\Repositories\MemberSMS;
use App\Repository\Middleware\AuthPrms;
use App\Repository\Middleware\MiddlewareInterface\AuthPrmsInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("App\Repository\MjInterface\AuthInterface",'App\Repository\MJ\Auth\Auth');
        $this->app->bind("App\Repository\MjInterface\RoleInterface",'App\Repository\MJ\Auth\Role');
        $this->app->bind(AuthPrmsInterface::class,AuthPrms::class);
        $this->app->bind(MemberCreditInterface::class,MemberCredit::class);
        app()->bind(MemberInterface::class,Member::class);
        app()->bind(MemberSettingInterface::class,MemberSetting::class);
        app()->bind(MemberSMSInterface::class,MemberSMS::class);

    }
}
