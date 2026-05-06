<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooks extends Migration
{
    public function up()
    {
        $this->forge->addField([
    'id' => ['type' => 'INT', 'auto_increment' => true],
    'isbn' => ['type' => 'VARCHAR', 'constraint' => 20],
    'title' => ['type' => 'VARCHAR', 'constraint' => 255],
    'author' => ['type' => 'VARCHAR', 'constraint' => 255],
    'publisher' => ['type' => 'VARCHAR', 'constraint' => 255],
    'year' => ['type' => 'INT'],
    ]);
    }

    public function down()
    {
        //
    }
}
