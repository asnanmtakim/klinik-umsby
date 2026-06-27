<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaksosRegistrationsTable extends Migration
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
            'baksos_service_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'umur' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('baksos_service_id', 'baksos_services', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('baksos_registrations');
    }

    public function down()
    {
        $this->forge->dropTable('baksos_registrations');
    }
}
