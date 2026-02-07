<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sections.profile');
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
