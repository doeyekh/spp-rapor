<?php

namespace App\Models;

use CodeIgniter\Model;

class JenjangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jenjang';
    protected $primaryKey       = 'id_jenjang';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jenjang','nama','status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
}
