<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegistrasiSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_registrasi' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_siswa'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'nipd'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 16,
            ],
            'kelas'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 20,
            ],
            'id_tahun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_lembaga'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_jenjang'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'status' => [
                'type'  => 'ENUM',
                'constraint' => ['1','0'],
            ],
            'is_active' => [
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
        $this->forge->addKey('id_registrasi', true);
        $this->forge->addForeignKey('id_siswa','siswa','id_siswa');
        $this->forge->addForeignKey('id_tahun','tahunajar','id_tahun');
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_jenjang','jenjang','id_jenjang');
        $this->forge->createTable('registrasi');
    }

    public function down()
    {
        $this->forge->dropTable('registrasi');
    }
}
