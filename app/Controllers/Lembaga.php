<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;
use App\Models\JenjangModel;
use App\Models\GuruModel;
use App\Models\LembagaModel;
use App\Models\WakasekModel;

class Lembaga extends BaseController
{
    function __construct()
    {
        $this->jenjangmodel = new JenjangModel();
        $this->gurumodel = new GuruModel();
        $this->lembagamodel = new LembagaModel();
        $this->wakasekmodel = new WakasekModel();
    }
    public function index()
    {
        $data = [
            'title' =>'Daftar Lembaga',
            'jenjang' => $this->jenjangmodel->findAll(),
            'guru' => $this->gurumodel->findAll(),
        ];
        return view('page/lembaga',$data);
    }
    public function insert()
    {
        if($this->request->isAjax())
        {
            $uuid = Uuid::uuid4()->toString();
            if($this->request->getVar('status') == '1')
            {
                $jabatan = 'Kepala Sekolah';
            }else{
                $jabatan = 'Koordinator'; 
            }
            $data = [
                'id_lembaga' => $uuid,
                'npsn'       => $this->request->getVar('npsn'),
                'id_jenjang' => $this->request->getVar('tingkat'),
                'nama_sekolah' => $this->request->getVar('nama'),
                'status' => $this->request->getVar('status'),
                'id_guru' => $this->request->getVar('kepsek'),
                'is_active' => 1
            ];
            $data2 =[
                'id_wakasek' => $uuid,
                'jabatan' => $jabatan,
                'id_guru' => $this->request->getVar('kepsek'),
                'id_lembaga' => $uuid,
                'id_tahun' => tahunajar()->id_tahun,
                'is_active' => 1
            ];
            if($this->lembagamodel->insert($data))
            {
                $this->wakasekmodel->insert($data2);
            }
        }
    }
    public function get()
    {
        if($this->request->isAjax())
        {
            $builder = $this->db->table('lembaga')
                                ->select('id_lembaga,npsn, nama_sekolah,guru.nama,lembaga.status')
                                ->select('jenjang.nama as namajenjang')
                                ->join('jenjang','jenjang.id_jenjang=lembaga.id_jenjang')
                                ->join('guru','guru.id_guru=lembaga.id_guru');
            return DataTable::of($builder)
                            ->addNumbering('nomor')->toJson(true);
        }
    }
}
