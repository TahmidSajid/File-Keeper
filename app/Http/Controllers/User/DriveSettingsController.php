<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DriveSettings;
use Exception;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DriveSettingsController extends Controller
{
    public function index()
    {
        $page_title = 'Drive Settings';

        $drive_settings = DriveSettings::first();

        return view('admin.sections.drive-settings',compact('page_title','drive_settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'client_id'     => 'required|string',
            'client_secret' => 'required|string',
        ]);

        try {
            DriveSettings::updateOrCreate([],[
                'google_client_id'  => $validated['client_id'],
                'google_client_secret'  => $validated['client_secret'],
            ]);
        } catch (Exception $e) {
            return back()->with('error','Something went wrong. Please try again!');
        }

        return back()->with('success','Drive Settings Updated Successfully');

    }

    /**
     * Redirect to Google for authorization
     */
    public function redirectToGoogle()
    {
        $drive_settings = DriveSettings::first();

        $client_id = $drive_settings['google_client_id'];
        $client_secret = $drive_settings['google_client_secret'];

        if (!$client_id || !$client_secret) {
            return back()->with('error', 'Please save Client ID and Client Secret first!');
        }

        $client = new GoogleClient();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri(route('user.drive.handle.callback'));
        $client->setScopes([GoogleDrive::DRIVE]);
        $client->setAccessType('offline');
        $client->setPrompt('consent'); // Force to get refresh token

        $auth_url = $client->createAuthUrl();

        return redirect($auth_url);
    }



    /**
     * Handle Google callback
     */
    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('user.drive.index')
                ->with('error', 'Authorization failed. No code received from Google.');
        }

        $drive_settings = DriveSettings::first();
        $client_id      = $drive_settings['google_client_id'];
        $client_secret  = $drive_settings['google_client_secret'];

        try {
            $client = new GoogleClient();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri(route('user.drive.handle.callback'));

            // Exchange authorization code for access token
            $token = $client->fetchAccessTokenWithAuthCode($request->code);

            if (isset($token['error'])) {
                throw new Exception($token['error_description'] ?? 'Unknown error');
            }

            if (!isset($token['refresh_token'])) {
                throw new Exception('No refresh token received. Try revoking access and authorizing again.');
            }

            // Save refresh token to database
            $drive_settings->google_refresh_token = $token['refresh_token'];
            $drive_settings->save();

            // Clear config cache
            Artisan::call('config:clear');

            return redirect()->route('user.drive.index')
                ->with('success', 'Refresh token generated and saved successfully! ✓');

        } catch (Exception $e) {
            return redirect()->route('user.drive.index')
                ->with('error', 'Failed to get refresh token: ' . $e->getMessage());
        }
    }


    public function fileUpload(Request $request)
    {
        $validated = $request->validate([
            'doc_file' => 'required',
        ]);

        $file = $request->file('doc_file');
        $file_name = Str::uuid() .'.'. $file->getClientOriginalName();

        Storage::disk('google_dynamic')->write($file_name, file_get_contents($file));

        return back()->with('success','File uploaded successfully');
    }

}
