<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_jenjangkelas'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_lembaga'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_kurikulum'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_guru'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_tahun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'nama_kelas'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
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
        $this->forge->addKey('id_kelas', true);
        $this->forge->addForeignKey('id_jenjangkelas','jenjangkelas','id_jenjangkelas');
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->addForeignKey('id_kurikulum','kurikulum','id_kurikulum');
        $this->forge->addForeignKey('id_tahun','tahunajar','id_tahun');
        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}
