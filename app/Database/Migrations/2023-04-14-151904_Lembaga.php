<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lembaga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lembaga' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'npsn' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            
            'nama_sekolah' =>[
                'type'          => 'VARCHAR',
                'constraint'    => 50,
            ],
            'id_guru'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'id_jenjang'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'alamat' =>[
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'rt' =>[
                'type' => 'VARCHAR',
                'constraint' => '3'
            ],
            'rw' =>[
                'type' => 'VARCHAR',
                'constraint' => '3'
            ],
            'desa' =>[
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'kecamatan' =>[
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'kabupaten' =>[
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'provinsi' =>[
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '50'
            ],
            'foto' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
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
        $this->forge->addKey('id_lembaga', true);
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->addForeignKey('id_jenjang','jenjang','id_jenjang');
        
        $this->forge->createTable('lembaga');
    }

    public function down()
    {
        $this->forge->dropTable('lembaga');
    }
}
