<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DriveSettings;
use App\Models\Files;
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

        $files = Files::get();

        return view('admin.pages.drive-settings', compact('page_title', 'drive_settings', 'files'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'client_id'     => 'required|string',
            'client_secret' => 'required|string',
        ]);

        try {
            DriveSettings::updateOrCreate([], [
                'google_client_id'  => $validated['client_id'],
                'google_client_secret'  => $validated['client_secret'],
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again!');
        }

        return back()->with('success', 'Drive Settings Updated Successfully');
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
        $client->setRedirectUri(route('admin.drive.handle.callback'));
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
            return redirect()->route('admin.drive.index')
                ->with('error', 'Authorization failed. No code received from Google.');
        }

        $drive_settings = DriveSettings::first();
        $client_id      = $drive_settings['google_client_id'];
        $client_secret  = $drive_settings['google_client_secret'];

        try {
            $client = new GoogleClient();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri(route('admin.drive.handle.callback'));

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

            return redirect()->route('admin.drive.index')
                ->with('success', 'Refresh token generated and saved successfully! ✓');
        } catch (Exception $e) {
            return redirect()->route('admin.drive.index')
                ->with('error', 'Failed to get refresh token: ' . $e->getMessage());
        }
    }


    public function fileUpload(Request $request)
    {
        $validated = $request->validate([
            'doc_file' => 'required',
        ]);



        try {
            $file = $request->file('doc_file');
            $file_name = Str::uuid() . '.' . $file->getClientOriginalExtension();

            Storage::disk('google_dynamic')->write($file_name, file_get_contents($file));

            Files::create([
                'file_name' => $file_name,
                'user_id'   => auth()->guard('admin')->user()->id,
            ]);

        } catch (Exception $e) {

            Files::where('user_id',auth()->guard('admin')->user()->id)->where('file_name', $file_name)->delete();
            return back()->with('error', 'Something went wrong. Please try again!');
        }

        return back()->with('success', 'File uploaded successfully');
    }

    public function fileDelete(Request $request)
    {

        $validated = $request->validate([
            'file_name' => 'required',
        ]);

        // dd($validated['file_name']);

        try {

            Storage::disk('google_dynamic')->delete($validated['file_name']);

            Files::where('user_id',auth()->guard('admin')->user()->id)->where('file_name', $validated['file_name'])->delete();

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again!');
        }

        return back()->with('success', 'File deleted successfully');
    }

    /**
     * Download file from Google Drive
     */
    public function downloadFile($file_name)
    {
        try {
            // Check if file exists
            if (!Storage::disk('google_dynamic')->fileExists($file_name)) {
                return back()->with('error', 'File not found!');
            }

            // Read file from Google Drive
            $content = Storage::disk('google_dynamic')->read($file_name);

            // Get file type
            $mimeType = Storage::disk('google_dynamic')->mimeType($file_name);

            // Send file to browser as download
            return response($content)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $file_name . '"');

        } catch (Exception $e) {
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    /**
     * View/Open file
     */
    public function viewFile($file_name)
    {

        // dd('check');

        try {
            if (!Storage::disk('google_dynamic')->fileExists($file_name)) {
                abort(404, 'File not found');
            }

            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $content = Storage::disk('google_dynamic')->read($file_name);
            $mimeType = Storage::disk('google_dynamic')->mimeType($file_name);

            // Images
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'])) {
                return response($content)
                    ->header('Content-Type', $mimeType)
                    ->header('Cache-Control', 'public, max-age=3600');
            }

            // PDFs
            if ($extension === 'pdf') {
                return response($content)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="' . $file_name . '"');
            }

            // Videos
            if (in_array($extension, ['mp4', 'webm', 'ogg', 'avi', 'mov'])) {
                return response($content)
                    ->header('Content-Type', $mimeType)
                    ->header('Content-Disposition', 'inline; filename="' . $file_name . '"');
            }

            // Text files
            if (in_array($extension, ['txt', 'json', 'xml', 'csv', 'log', 'md'])) {
                return view('file-manager.view-text', [
                    'filename' => $file_name,
                    'content' => $content,
                    'extension' => $extension
                ]);
            }

            // Download for other types
            return $this->download($file_name);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to open file: ' . $e->getMessage());
        }
    }

    public function testConnection()
    {
        try {
            // Try to list files
            $files = Storage::disk('google_dynamic')->listContents('/', false);

            return back()->with('success', 'Connection successful!');

        } catch (Exception $e) {
            return back()->with('error', 'Connection failed');
        }
    }
}
