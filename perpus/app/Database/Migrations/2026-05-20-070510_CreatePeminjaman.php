<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'book_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'tanggal_pinjam' => [
                'type' => 'DATE',
            ],

            'tanggal_jatuh_tempo' => [
                'type' => 'DATE',
            ],

            'tanggal_kembali' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Dipinjam', 'Dikembalikan'],
                'default'    => 'Dipinjam',
            ],

            'denda' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],

            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Bayar', 'Lunas'],
                'default'    => 'Belum Bayar',
            ],

            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}