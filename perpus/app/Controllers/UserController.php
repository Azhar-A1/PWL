<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    // =====================================================
    // HALAMAN KELOLA USER
    // =====================================================
    public function index()
{
    $keyword = $this->request->getGet('search');

    if ($keyword) {

        $users = $this->user
            ->groupStart()
            ->like('name', $keyword)
            ->orLike('username', $keyword)
            ->orLike('email', $keyword)
            ->groupEnd()
            ->findAll();

    } else {

        $users = $this->user->findAll();

    }

    $data = [

        'users' => $users,

        'totalUser' => $this->user->countAll(),

        'totalAdmin' => $this->user->where('role_id',1)->countAllResults(),

        'totalStaff' => $this->user->where('role_id',2)->countAllResults(),

        'totalMember' => $this->user->where('role_id',3)->countAllResults(),

    ];

    return view('users/index',$data);
}
    // =====================================================
    // UBAH ROLE MEMBER <-> STAFF
    // =====================================================
    public function role($id)
    {
        $user = $this->user->find($id);

        if (!$user) {

            return redirect()->back()
                ->with('error', 'User tidak ditemukan.');

        }

        // Admin tidak boleh diubah
        if ($user['role_id'] == 1) {

            return redirect()->back()
                ->with('error', 'Role Admin tidak dapat diubah.');

        }

        // Member -> Staff
        if ($user['role_id'] == 3) {

            $role = 2;

        }
        // Staff -> Member
        else {

            $role = 3;

        }

        $this->user->update($id, [

            'role_id' => $role

        ]);

        return redirect()->back()
            ->with('success', 'Role berhasil diubah.');
    }

    // =====================================================
    // HAPUS USER
    // =====================================================
    public function delete($id)
    {
        $user = $this->user->find($id);

        if (!$user) {

            return redirect()->back()
                ->with('error', 'User tidak ditemukan.');

        }

        // Tidak boleh menghapus akun sendiri
        if (session()->get('user_id') == $id) {

            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');

        }

        // Admin tidak boleh dihapus
        if ($user['role_id'] == 1) {

            return redirect()->back()
                ->with('error', 'User Admin tidak dapat dihapus.');

        }

        $this->user->delete($id);

        return redirect()->back()
            ->with('success', 'User berhasil dihapus.');
    }

    public function storeStaff()
{
    if(session()->get('role_id') != 1){

        return redirect()->back()
            ->with('error','Akses ditolak.');

    }

    $username = $this->request->getPost('username');
    $email    = $this->request->getPost('email');

    if($this->user->where('username',$username)->first()){

        return redirect()->back()
            ->with('error','Username sudah digunakan.');

    }

    if($this->user->where('email',$email)->first()){

        return redirect()->back()
            ->with('error','Email sudah digunakan.');

    }

    $this->user->save([

        'name'=>$this->request->getPost('name'),

        'username'=>$username,

        'email'=>$email,

        'phone'=>$this->request->getPost('phone'),

        'password'=>password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        ),

        'role_id'=>2,

        'created_at'=>date('Y-m-d H:i:s'),

        'updated_at'=>date('Y-m-d H:i:s')

    ]);

    return redirect()->back()
        ->with('success','Staff berhasil ditambahkan.');
}

}   