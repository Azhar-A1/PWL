<?php

namespace App\Controllers;

use App\Models\UserModel;

class Staff extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
{
    // Hanya Admin
    if(session()->get('role_id') != 1){

        return redirect()->to('/dashboard');

    }

    $keyword = $this->request->getGet('search');

    $builder = $this->userModel
                    ->where('role_id',2);

    if($keyword){

        $builder->groupStart()

                ->like('username',$keyword)

                ->orLike('email',$keyword)

                ->groupEnd();

    }

    $staff = $builder->findAll();

    return view('staff/index',[

        'staff'=>$staff,

        'totalStaff'=>$this->userModel
            ->where('role_id',2)
            ->countAllResults()

        ]);
    }

    public function create()
    {
        return view('staff/create');
    }

    public function store()
    {
        $this->userModel->save([

            'username'=>$this->request->getPost('username'),

            'email'=>$this->request->getPost('email'),

            'password'=>password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'role_id'=>2,

            'created_at'=>date('Y-m-d H:i:s'),

            'updated_at'=>date('Y-m-d H:i:s')

        ]);

        return redirect()->to('/staff')
            ->with('success','Staff berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);

        return redirect()->to('/staff')
            ->with('success','Staff berhasil dihapus.');
    }

}