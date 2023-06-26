<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_siswa','nik','nisn','nama_siswa','jenis_kelamin','tempat_lahir','tgl_lahir','dietrima_kelas','diterima','alamat','rt','rw','desa','kecamatan','kabupaten','provinsi','no_hp','password','nama_ayah','nik_ayah','pekerjaan_ayah','nama_ibu','nik_ibu','pekerjaan_ibu','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRegis($data=[]){
        return $this
        ->join('registrasi','registrasi.id_siswa=siswa.id_siswa')
        ->join('lembaga','lembaga.id_lembaga=registrasi.id_lembaga')
        ->where($data)->first();
    }
}
