<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStocksTable extends Migration
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
            'qty' => [
                'type' => 'INT',
                'default' => 0,
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
        $this->forge->addForeignKey('store_id', 'stores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['product_id', 'store_id']);
        $this->forge->createTable('stocks');
    }

    public function down()
    {
        $this->forge->dropTable('stocks');
    }
}
