<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'type'              => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'name'              => ['type' => 'varchar', 'constraint' => '255'],
            'name_en'           => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'route'             => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'params'            => ['type' => 'text', 'null' => true],
            'icon'              => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'filter'            => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'filter_value'      => ['type' => 'varchar', 'constraint' => '255', 'null' => true],
            'parent'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'order'             => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('site_menus');
    }

    public function down()
    {
        $this->forge->dropTable('site_menus', true);
    }
}
