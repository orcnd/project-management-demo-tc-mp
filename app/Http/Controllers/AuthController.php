<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

/**
 * Auth Controller
 *
 * @category App
 * @package  App\Http\Controllers
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  MIT License (https://orcuncandan.mit-license.org)
 * @link     https://orcuncandan.com
 */
class AuthController extends Controller
{
    /**
     * Login a user
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function login(Request $request)
    {
        $request->validate(
            [
            'email' => 'required|email',
            'password' => 'required',
            ]
        );
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $user->token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(
                [
                'success' => true,
                'user' => $user,
                'message' => 'Login Success',
                'token' => $user->token,
                ]
            );
        } else {
            return response()->json(
                [
                'success' => false,
                'message' => 'Invalid Credentials',
                ], 422
            );
        }
    }

    /**
     * Register a new user
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function register(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required', 'string', 'email', 'max:255', 'unique:users'
                ],
                'password' => [
                    'required', 'confirmed', Rules\Password::defaults()
                ],
            ]
        );

        $user = User::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            ]
        );
        event(new Registered($user));

        $user->token = $user->createToken('auth_token')->plainTextToken;
        $user->roles()->attach(
            \App\Models\Role::where('title', 'user')->first()
        );

        return response()->json(
            [
            'success' => true,
            'message' => 'Register Success',
            'user' => $user,
            'token' => $user->token,
            ]
        );
    }

    /**
     * Logout a user
     *
     * @param Request $request request
     *
     * @return void
     */
    function logout(Request $request)
    {
        Auth::user()?->currentAccessToken()?->delete();
        return response()->json(
            [
            'success' => true,
            'message' => 'Logout Success',
            ]
        );
    }

    function me()
    {
        return response()->json(
            [
            'success' => true,
            'message' => 'Get User Success',
            'user' => Auth::user(),
            ]
        );
    }
}
