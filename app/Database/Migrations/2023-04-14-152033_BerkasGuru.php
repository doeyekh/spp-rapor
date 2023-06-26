<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BerkasGuru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_guru'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'nama_berkas'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 150,
            ],
            'file_berkas'   =>[
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
        $this->forge->addKey('id_berkas', true);
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->createTable('berkas');
    }

    public function down()
    {
        $this->forge->dropTable('berkas');
    }
}
