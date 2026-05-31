<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockMovementsTable extends Migration
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
            'store_id' => [
                'type' => 'INT',
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['in', 'out', 'adjustment'],
            ],
            'qty' => [
                'type' => 'INT',
            ],
            'reference' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('type');
        $this->forge->addKey('reference');
        $this->forge->addKey('created_at');
        $this->forge->createTable('stock_movements');
    }

    public function down()
    {
        $this->forge->dropTable('stock_movements');
    }
}
