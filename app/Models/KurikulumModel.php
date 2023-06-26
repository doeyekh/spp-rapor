<?php

namespace App\Models;

use CodeIgniter\Model;

class KurikulumModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kurikulum';
    protected $primaryKey       = 'id_kurikulum';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kurikulum','id_jenjang','nama_kurikulum','is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKurikulum()
   {
    $builder = $this->select('id_kurikulum,nama_kurikulum,is_active,jenjang.nama')
                    ->join('jenjang', 'jenjang.id_jenjang = kurikulum.id_jenjang');
    return $builder;
   }

}
