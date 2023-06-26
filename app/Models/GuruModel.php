<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guru';
    protected $primaryKey       = 'id_guru';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_guru','nik','nama','jenis_kelamin','tempat_lahir','tgl_lahir','alamat','rt','rw','desa','kecamatan','kabupaten','provinsi','email','no_hp','password','foto','is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGuru($id = false)
   {
        return $this->findAll();
     //    return $this->join('wakasek','wakasek.id_guru=guru.id_guru')->where('jabatan !=','Kepala Sekolah')->groupBy('wakasek.id_guru')->findAll();
     
   }
}
