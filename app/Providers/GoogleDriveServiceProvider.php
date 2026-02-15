<?php

namespace App\Providers;

use App\Models\DriveSettings;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            Storage::extend('google_dynamic', function ($app, $config) {
                // Get credentials from database

                $drive_settings = DriveSettings::first();

                $client_id = $drive_settings['google_client_id'];
                $client_secret = $drive_settings['google_client_secret'];
                $refresh_token = $drive_settings['google_refresh_token'];
                $folder_id = null;

                // Check if credentials exist
                if (!$client_id || !$client_secret || !$refresh_token) {
                    throw new Exception('Google Drive credentials not configured');
                }

                // Create Google Client
                $client = new GoogleClient();
                $client->setClientId($client_id);
                $client->setClientSecret($client_secret);
                $client->refreshToken($refresh_token);

                // Create Google Drive Service
                $service = new GoogleDrive($client);

                // Create Adapter
                $adapter = new GoogleDriveAdapter($service, $folder_id);

                // Return Flysystem
                return new Filesystem($adapter);
            });
        } catch (Exception $e) {
            // Silently fail if table doesn't exist yet (during migration)
            Log::debug('Google Drive disk not available: ' . $e->getMessage());
        }
    }
}
