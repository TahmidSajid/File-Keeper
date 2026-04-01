<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "Profile";

        return view('admin.pages.profile',compact('page_title'));
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
            delete_image(auth()->guard('admin')->user()->image, 'profile');
            $image_name = upload_image($request->file('profile_img'), 'profile');
        }


        $user = Admin::authUser()->first();

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
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);


        $user = Admin::authUser()->first();

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
