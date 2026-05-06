<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id' => 1 // admin
            ],
            [
                'username' => 'member',
                'password' => password_hash('member123', PASSWORD_DEFAULT),
                'role_id' => 3 // member
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}