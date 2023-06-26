<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Guru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_guru' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'nik' => [
                'type'       => 'int',
                'constraint' => '16',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L','P'],
            ],
            'tempat_lahir' => [
                'type'  => 'VARCHAR',
                'constraint'    => '50'
            ],
            'tgl_lahir' => [
                'type'  => 'DATE'
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
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '12'
            ],
            'password' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'foto' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
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
        $this->forge->addKey('id_guru', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
