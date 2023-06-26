<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'surat';
    protected $primaryKey       = 'id_surat';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_surat','id_lembaga','id_tahun','jenis_surat','no_surat','perihal_surat','tujuan','tgl_surat','ket_surat','file_surat'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getSurat($where=[])
    {
        return $this->select('id_surat,id_lembaga,id_tahun,no_surat,perihal_surat,tujuan,ket_surat,file_surat,tgl_surat')
        // ->join('lembaga','lembaga.id_lembaga=surat.id_lembaga')
        // ->join('tahunajar','tahunajar.id_tahun=surat.id_tahun')
        ->where($where);
    }
}
