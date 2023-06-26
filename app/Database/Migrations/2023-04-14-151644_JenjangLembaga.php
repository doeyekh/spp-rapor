<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenjangLembaga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenjang' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['formal','Non Formal'],
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
        $this->forge->addKey('id_jenjang', true);
        $this->forge->createTable('jenjang');
    }

    public function down()
    {
        $this->forge->dropTable('jenjang');
    }
}
