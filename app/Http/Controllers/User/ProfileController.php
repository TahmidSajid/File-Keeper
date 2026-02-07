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
        return view('sections.profile');
    }

    /**
     * Update User Profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);


        if($request->hasFile('profile_img')){
            $manager = new ImageManager(new Driver());

            $image = $manager->read($request->file('profile_img'));

            $image->resize(300,300, function($constraint){
                $constraint->aspectRation();
                $constraint->upsize();
            });

            $image_name = Str::uuid().'.webp';

            $image->toWebp(80)->save(public_path('assets/frontend/user/'.$image_name));
        }


        $user = User::authUser()->first();

        try {
            $user->update([
                'name'  => $validated['name'],
                'email'  => $validated['email'],
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
