<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TahunAjarans extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahun' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
            ],
            'tahunpelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'smt' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['1','2'],
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
        $this->forge->addKey('id_tahun', true);
        $this->forge->createTable('tahunajar');
    }

    public function down()
    {
        $this->forge->dropTable('tahunajar');
    }
}
