<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaksosServicesTable extends Migration
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
            'nama_pelayanan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kuota' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
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
        $this->forge->createTable('baksos_services');
    }

    public function down()
    {
        $this->forge->dropTable('baksos_services');
    }
}
