<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasJenjangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jenjangkelas';
    protected $primaryKey       = 'id_jenjangkelas';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jenjangkelas','id_jenjang','nama_tingkat','tingkat_akhir'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getJenjang()
   {
    $builder = $this->select('id_jenjangkelas,nama_tingkat,tingkat_akhir,jenjang.nama')
                    ->join('jenjang', 'jenjang.id_jenjang = jenjangkelas.id_jenjang');
    return $builder;
   }
}
