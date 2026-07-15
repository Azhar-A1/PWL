<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'isbn' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'author' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'publisher' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'year' => [
                'type' => 'INT'
            ],
            'cover' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'stock' => [
                'type' => 'INT',
                'default' => 0
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('books');
    }

    public function down()
    {
        $this->forge->dropTable('books');
    }
}