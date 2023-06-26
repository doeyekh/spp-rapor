<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaRombelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'anggotarombel';
    protected $primaryKey       = 'id_anggotarombel';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_anggotarombel','id_kelas','id_siswa','is_active','tarik'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getRegister($data=[]){
        return $this->select('anggotarombel.id_kelas,siswa.id_siswa,siswa.nama_siswa,siswa.nisn,registrasi.nipd')
        ->join('registrasi','registrasi.id_siswa=anggotarombel.id_siswa')
        ->join('siswa','siswa.id_siswa=anggotarombel.id_siswa')
        ->join('kelas','kelas.id_kelas=anggotarombel.id_kelas')
        ->where($data);
    }
    public function getAnggota($data=[]){
        return $this->join('kelas','kelas.id_kelas=anggotarombel.id_kelas')->where($data)->first();
    }
    public function Updateanggota($id=[],$data=[]){
        return $this->where($id)->update($data);
    }
}
