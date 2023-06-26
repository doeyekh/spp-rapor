<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasJenjang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenjangkelas' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_jenjang'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'nama_tingkat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'tingkat_akhir'   =>[
                'type'          => 'ENUM',
                'constraint'    => ['1','0'],
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
        $this->forge->addKey('id_jenjangkelas', true);
        $this->forge->addForeignKey('id_jenjang','jenjang','id_jenjang');
        $this->forge->createTable('jenjangkelas');
    }

    public function down()
    {
        $this->forge->dropTable('jenjangkelas');
    }
}
