<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasSiswaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'berkassiswa';
    protected $primaryKey       = 'id_berkassiwa';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_berkassiwa','id_siswa','ijazah','skhun','kk','akta','ktp_ayah','ktp_ibu','kip','kis','lain'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getData($id=[])
    {
        return $this->select('id_berkassiwa,siswa.nama_siswa,ijazah,skhun,kk,akta,ktp_ayah,ktp_ibu,kip,kis,lain')
                    ->join('siswa','siswa.id_siswa=berkassiswa.id_siswa')
                    ->join('registrasi','registrasi.id_siswa=berkassiswa.id_siswa')
                    ->where('registrasi.is_active',1)
                    ->where($id);
    }
    
}
