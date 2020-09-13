<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class SigninController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        /**
         * @var User $user
         */
        $user = User::where('email', $request->get('email'))->first();
        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return response(
                ['message' => 'Неверный логин или пароль',],
                Response::HTTP_UNAUTHORIZED
            );
        }
            $token = $user->createToken($request->ip())->plainTextToken;
            return response([
                'token' => $token,
                'user_id' => $user->id,
                'user_name' => $user->name
            ], Response::HTTP_ACCEPTED);
        }
}
