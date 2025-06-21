<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Google\Client;
use Google\Service\Drive;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //  conect Google Drive
        Storage::extend('google-drive-ext', function ($app, $config) {
            $client = new Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->setAccessType('offline');
            $client->setApprovalPrompt('force');
            $client->setScopes(['https://www.googleapis.com/auth/drive']);
            $client->refreshToken($config['refreshToken']);
            $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);

            $service = new Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);

            return new Filesystem($adapter);
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('unreadCount', $user->unreadNotifications->count());
            }
        });
    }
}
