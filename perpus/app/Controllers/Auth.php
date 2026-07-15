<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ==========================
    // HALAMAN LOGIN
    // ==========================
    public function login()
    {
        return view('login');
    }

    // ==========================
    // PROSES LOGIN
    // ==========================
    public function process()
    {
        $model = new UserModel();

        $login    = trim($this->request->getPost('login'));
        $password = $this->request->getPost('password');

        // Cari berdasarkan Username ATAU Email
        $user = $model->groupStart()
            ->where('username', $login)
            ->orWhere('email', $login)
            ->groupEnd()
            ->first();

        if ($user && password_verify($password, $user['password'])) {

            session()->set([
                'user_id'   => $user['id'],
                'role_id'   => $user['role_id'],
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Username/Email atau Password salah.');
    }

    // ==========================
    // LOGOUT
    // ==========================
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    // ==========================
    // HALAMAN REGISTER
    // ==========================
    public function register()
    {
        return view('register');
    }

    // ==========================
    // PROSES REGISTER
    // ==========================
    public function registerProcess()
    {
        $model = new UserModel();

        $name      = trim($this->request->getPost('name'));
        $username  = trim($this->request->getPost('username'));
        $email     = trim($this->request->getPost('email'));
        $phone     = trim($this->request->getPost('phone'));
        $password  = $this->request->getPost('password');
        $confirm   = $this->request->getPost('confirm_password');

        // ==========================
        // VALIDASI
        // ==========================

        if ($password != $confirm) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfirmasi password tidak cocok.');

        }

        if (strlen($password) < 8) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Password minimal 8 karakter.');

        }

        if ($model->where('username', $username)->first()) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Username sudah digunakan.');

        }

        if ($model->where('email', $email)->first()) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah digunakan.');

        }

        if ($model->where('phone', $phone)->first()) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor WhatsApp sudah digunakan.');

        }

        // ==========================
        // SIMPAN USER
        // ==========================

        $model->save([

            'name'       => $name,
            'username'   => $username,
            'email'      => $email,
            'phone'      => $phone,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role_id'    => 3, // Member
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'phone' => $this->request->getPost('phone')

        ]);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }
}