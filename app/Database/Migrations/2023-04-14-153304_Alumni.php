<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alumni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumni' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_siswa'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_tahun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_lembaga'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'jenis_alumni'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'alasan'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 20,
            ],
            'pindahke'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 30,
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
        $this->forge->addKey('id_alumni', true);
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_siswa','siswa','id_siswa');
        $this->forge->addForeignKey('id_tahun','tahunajar','id_tahun');
        $this->forge->createTable('alumni');
    }

    public function down()
    {
        $this->forge->dropTable('alumni');
    }
}
