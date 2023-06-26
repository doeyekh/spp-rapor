<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'alumni';
    protected $primaryKey       = 'id_alumni';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_alumni','id_siswa','id_tahun','id_lembaga','jenis_alumni','alasan','pindahke'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getAlumni($data=[]){
        return $this->select('id_alumni,siswa.nama_siswa,siswa.nisn,id_tahun,jenis_alumni,alasan,pindahke,alumni.created_at')
                    ->join('siswa','siswa.id_siswa=alumni.id_siswa')
                    ->join('lembaga','lembaga.id_lembaga=alumni.id_lembaga')
                    ->where($data);
    }
}
