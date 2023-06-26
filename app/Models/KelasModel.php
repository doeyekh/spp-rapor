<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kelas';
    protected $primaryKey       = 'id_kelas';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kelas','id_jenjangkelas','id_kurikulum','id_guru','id_lembaga','id_tahun','nama_kelas','is_active','tarik'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getKelas($id = [])
   {
    $builder = $this->select('id_kelas,jenjangkelas.nama_tingkat,kelas.id_lembaga,guru.nama,nama_kelas,kurikulum.nama_kurikulum')
    ->join('jenjangkelas', 'jenjangkelas.id_jenjangkelas = kelas.id_jenjangkelas')
    ->join('lembaga','lembaga.id_lembaga=kelas.id_lembaga')
    ->join('guru','guru.id_guru=kelas.id_guru')
    ->join('kurikulum','kurikulum.id_kurikulum=kelas.id_kurikulum')
    ->where('id_tahun',tahunajar()->id_tahun)
    ->where($id);
    return $builder;
   }
   public function getKelasData($id=[])
   {
    return $this->join('jenjangkelas','kelas.id_jenjangkelas=jenjangkelas.id_jenjangkelas')->where($id);
   }
    
}
