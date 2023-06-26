<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasGuruModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'berkas';
    protected $primaryKey       = 'id_berkas';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_berkas','id_guru','nama_berkas','file_berkas'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


   public function getBerkas($id)
   {
    return $this->db->table('berkas')
    ->join('guru','guru.id_guru=berkas.id_guru')
    ->where(['berkas.id_guru'=> $id])
    ->get()->getResultArray();
   }
}
