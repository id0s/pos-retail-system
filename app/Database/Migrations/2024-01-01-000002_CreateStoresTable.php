<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'tax' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 10.00,
            ],
            'service_charge' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'status' => [
                'type' => 'TINYINT',
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('stores');
    }

    public function down()
    {
        $this->forge->dropTable('stores');
    }
}
