<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kurikulum extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kurikulum' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_jenjang' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
            ],
            'nama_kurikulum' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'is_active' => [
                'type'       => 'ENUM',
                'constraint' => ['1','0'],
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
        $this->forge->addKey('id_kurikulum', true);
        $this->forge->addForeignKey('id_jenjang','jenjang','id_jenjang');
        $this->forge->createTable('kurikulum');
    }

    public function down()
    {
        $this->forge->dropForeignKey('kurikulum','kurikulum_id_jenjang_foreign');
        $this->forge->dropTable('kurikulum');
    }
}
