<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdduserController extends Controller
{
    public function adduser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:15',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            return response(
                [
                    'message' => 'Пользователь с таким email уже существует',
                    ],
                Response::HTTP_UNAUTHORIZED
            );
        } else {
             User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);

             return response([
                 'message' => 'created',
             ],
            Response::HTTP_CREATED
        );

        }
    }
}
