<?php

namespace App\Http\Controllers;

// Remova a linha errada e coloque esta:

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        //form validaton
        $request->validate(
            //rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            //erro messages
            [
                'text_username.required' => 'O username é obrigatorio',
                'text_username.email' => 'Username deve ser um email valido',
                'text_password.required' => 'A senha é obrigatoria',
                'text_password.min' => 'O password deve ter pelo menos :min caracteres',
                'text_password.max' => 'O password deve ter pelo menos :max caracteres'
            ]
        );
        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        //check if user exists
        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorreto.');
        }

        //check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorreto.');
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // redirect to home
        return redirect()->to('/');
    }

    public function logout()
    {
        //logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
