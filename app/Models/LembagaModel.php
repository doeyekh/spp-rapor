<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lembaga';
    protected $primaryKey       = 'id_lembaga';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_lembaga','npsn','nama_sekolah','id_guru','id_jenjang','alamat','rt','rw','desa','kecamatan','kabupaten','provinsi','email','foto','status','is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getLembaga($id = false)
   {
    if($id==false){
        return $this->join('jenjang', 'jenjang.id_jenjang=lembaga.id_jenjang')->groupBy('jenjang.nama')->findAll();
    }else{
        $builder = $this->join('wakasek','wakasek.id_lembaga = lembaga.id_lembaga')
                        ->join('jenjang','jenjang.id_jenjang=lembaga.id_jenjang')
                    ->where('wakasek.id_guru', $id);
                    if(in_array('Operator',userLevel())){
                        $builder->where('jabatan','Operator');
                    }elseif(in_array('Koordinator',userLevel())){
                        $builder->where('jabatan','Koordinator');
                    }
        return $builder->findAll();
    }
   }
    public function getjenjang($id)
    {
        return $this->where(['id_lembaga'=> $id])->first();
    }
    public function getsekolah($id=[])
    {
        if($id==false){

            return $this->findAll();
        }else{

            return $this->where($id)->findAll();
        }
    }
}
