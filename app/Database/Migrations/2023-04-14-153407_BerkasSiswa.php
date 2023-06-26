<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BerkasSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkassiwa' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'id_siswa'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 36,
            ],
            'ijazah'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'skhun'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'kk'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'akta'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'ktp_ayah'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'ktp_ibu'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'kip'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'kis'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
            ],
            'lain'   =>[
                'type'          => 'VARCHAR',
                'constraint'    => 120,
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
        $this->forge->addKey('id_berkassiwa', true);
        $this->forge->addForeignKey('id_siswa','siswa','id_siswa');
        $this->forge->createTable('berkassiswa');
    }

    public function down()
    {
        $this->forge->dropTable('berkassiswa');
    }
}
