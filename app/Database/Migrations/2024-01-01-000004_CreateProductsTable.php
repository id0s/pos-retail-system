<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
            ],
            'supplier_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'null' => true,
            ],
            'barcode' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'null' => true,
            ],
            'purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'selling_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'minimum_stock' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('sku');
        $this->forge->addKey('barcode');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
