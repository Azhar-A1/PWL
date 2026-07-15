<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStaff extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'pustakawan'],
                'default' => 'pustakawan'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('staff');
    }

    public function down()
    {
        $this->forge->dropTable('staff');
    }
}