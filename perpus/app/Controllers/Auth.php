<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function process()
{
    $model = new UserModel();

    $user = $model->where('username', $this->request->getPost('username'))->first();

    if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
        
        session()->set([
            'user_id' => $user['id'],
            'role_id' => $user['role_id'],
            'logged_in' => true
        ]);

        // ✅ SEMUA KE DASHBOARD
        return redirect()->to('/dashboard');
    }

    return redirect()->back()->with('error', 'Username Atau Password Salah');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}