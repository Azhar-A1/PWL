<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        // Admin
        if (!$db->table('users')->where('username', 'admin')->get()->getRow()) {

            $db->table('users')->insert([
                'username'   => 'admin',
                'email'      => 'admin@perpus.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Staff
        if (!$db->table('users')->where('username', 'staff')->get()->getRow()) {

            $db->table('users')->insert([
                'username'   => 'staff',
                'email'      => 'staff@perpus.com',
                'password'   => password_hash('staff123', PASSWORD_DEFAULT),
                'role_id'    => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}