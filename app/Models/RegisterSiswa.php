<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterSiswa extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'registrasi';
    protected $primaryKey       = 'id_registrasi';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_registrasi','id_siswa','id_lembaga','id_jenjang','kelas','nipd','id_tahun','status','is_active','tarik'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRegistrasi($data=[]){
        return $this->select('siswa.nisn,siswa.foto,siswa.nik,siswa.nama_siswa,siswa.id_siswa,siswa.jenis_kelamin,nipd,kelas')
        ->join('siswa','siswa.id_siswa=registrasi.id_siswa')
        ->where($data);
    }
    
    public function getRegister($data=[]){
        return $this->select('siswa.nisn,siswa.nik,siswa.nama_siswa,siswa.id_siswa,siswa.jenis_kelamin,nipd,kelas')
        ->join('anggotarombel','anggotarombel.id_siswa=anggotarombel.id_siswa')
        ->join('siswa','siswa.id_siswa=registrasi.id_siswa')
        ->where($data);
    }
    public function UpdateRegistrasi($id=[],$data=[]){
        return $this->where($id)->update($data);
    }
}
