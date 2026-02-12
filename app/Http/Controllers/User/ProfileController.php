<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sections.profile');
    }

    /**
     * Update User Profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'email'     => 'required|email',
        ]);

        $image_name= null;

        if($request->hasFile('profile_img')){
            $image_name = upload_image($request->file('profile_img'), 'profile');
        }


        $user = User::authUser()->first();

        try {
            $user->update([
                'firstname' => $validated['firstname'],
                'lastname'  => $validated['lastname'],
                'email'     => $validated['email'],
            ]);

            if($request->hasFile('profile_img')){
                $user->update([
                    'image' => $image_name,
                ]);
            };

        } catch (Exception $e) {
           return back()->with('error','Something went wrong! Please try again');
        }

        return back()->with('success' ,'Profile Updated Successfuly');

    }

    public function passwordUpdate(Request $request)
    {
        $validated = $request->validate([
            'current_password'      => 'required|current_password',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);


        $user = User::authUser()->first();

        try {

            $user->update([
                'password'  => Hash::make($validated['password']),
            ]);

        } catch (Exception $e) {
            return back()->with('error','Somewhing went wronk! Please try again');
        }

        return back()->with('success' ,'Password Updated Successfuly');
    }
}
