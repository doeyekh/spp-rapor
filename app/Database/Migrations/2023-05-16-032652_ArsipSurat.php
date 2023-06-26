<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArsipSurat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_surat' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_lembaga'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_tahun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'jenis_surat'   =>[
                'type'          => 'ENUM',
                'constraint'    => ['Masuk','Keluar'],
            ],
            'no_surat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'perihal_surat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'tujuan'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'tgl_surat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'ket_surat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'file_surat'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
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
        $this->forge->addKey('id_surat', true);
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_tahun','tahunajar','id_tahun');
        $this->forge->createTable('surat');
    }

    public function down()
    {
        $this->forge->dropTable('berkassiswa');
    }
}
