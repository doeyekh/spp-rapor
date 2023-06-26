<?php

namespace App\Models;

use CodeIgniter\Model;

class WakasekModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'wakasek';
    protected $primaryKey       = 'id_wakasek';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_wakasek','jabatan','id_guru','id_lembaga','id_tahun','is_active','tarik'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getWakasek($where=[])
   {
    $builder = $this->select('id_wakasek, jabatan,guru.nama,wakasek.id_guru, wakasek.is_active,lembaga.nama_sekolah')
                  ->join('guru', 'guru.id_guru = wakasek.id_guru')
                  ->join('lembaga', 'lembaga.id_lembaga = wakasek.id_lembaga')
                  ->where('guru.is_active','1')
                  ->where('wakasek.is_active','1');
                  $builder->where('jabatan !=','Administrator')
                  ->where($where);
    return $builder;
   }
   
    
}
