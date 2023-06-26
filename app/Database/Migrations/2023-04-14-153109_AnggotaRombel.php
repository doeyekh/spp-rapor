<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnggotaRombel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_anggotarombel' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_kelas'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_siswa'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'is_active'   =>[
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
        $this->forge->addKey('id_anggotarombel', true);
        $this->forge->addForeignKey('id_kelas','kelas','id_kelas');
        $this->forge->addForeignKey('id_siswa','siswa','id_siswa');
        $this->forge->createTable('anggotarombel');
    }

    public function down()
    {
        $this->forge->dropTable('anggotarombel');
    }
}
