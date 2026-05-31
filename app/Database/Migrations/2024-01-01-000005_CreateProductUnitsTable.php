<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductUnitsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
            ],
            'unit_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'conversion_value' => [
                'type' => 'INT',
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
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
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_units');
    }

    public function down()
    {
        $this->forge->dropTable('product_units');
    }
}
