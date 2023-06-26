<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesertaDidik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswa' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
                'auto_increment' => false,
            ],
            'nik' => [
                'type'       => 'int',
                'constraint' => '16',
            ],
            'nisn' => [
                'type'       => 'int',
                'constraint' => '16',
            ],
            'nama_siswa' => [
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
            'diterima_kelas' => [
                'type'  => 'VARCHAR',
                'constraint' => '50'
            ],
            'diterima' => [
                'type'  => 'DATE',
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
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '12'
            ],
            'password' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'nama_ayah' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'nik_ayah' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'pekerjaan_ayah' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'nama_ibu' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'nik_ibu' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'pekerjaan_ibu' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
            ],
            'foto' => [
                'type'  => 'VARCHAR',
                'constraint' => '250'
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
        $this->forge->addKey('id_siswa', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
