<?php

namespace App\Providers;

use App\Contracts\HttpContact;
use App\Contracts\LogContact;
use App\Contracts\Mail\MessageContract;
use App\Contracts\NotificationContact;
use App\Contracts\Payment\BkashContact;
use App\Contracts\Transaction\TransactionContact;
use App\Managers\Mail\MessageManager;
use App\Managers\NotificationManager;
use App\Managers\Payment\BkashManager;
use App\Managers\HttpManager;
use App\Managers\LogManager;
use App\Managers\Transaction\TransactionManager;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Common .So need to add first
        $this->app->bind(HttpContact::class,HttpManager::class);
        $this->app->bind(LogContact::class,LogManager::class);

        // Rest of the dependency
        $this->app->bind(TransactionContact::class,TransactionManager::class);

        $this->app->bind(BkashContact::class,BkashManager::class);

        $this->app->bind(NotificationContact::class,NotificationManager::class);

        $this->app->bind(MessageContract::class,MessageManager::class);

        \Response::macro('attachment', function ($file_name,$file_type,$file_content) {

            $headers = [
                'Content-type'        => $file_type,
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"',
            ];

            return \Response::make($file_content, 200, $headers);

        });
    }
}
