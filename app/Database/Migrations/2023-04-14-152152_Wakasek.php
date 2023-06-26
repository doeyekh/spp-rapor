<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wakasek extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_wakasek' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'jabatan' => [
                'type'       => 'ENUM',
                'constraint' => ['Kepala Sekolah','Koordinator','Kurikulum','Kesiswaan','Bendahara','Wali Kelas','Tata Usaha','Kepala Jurusan','Operator'],
            ],
            'id_guru'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_lembaga'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_tahun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'is_active' => [
                'type'  => 'ENUM',
                'constraint' => ['1','0'],
            ],
            'tarik' => [
                'type'  => 'ENUM',
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
        $this->forge->addKey('id_wakasek', true);
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->addForeignKey('id_tahun','tahunajar','id_tahun');
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        
        $this->forge->createTable('wakasek');
    }

    public function down()
    {
        $this->forge->dropTable('wakasek');
    }
}
