<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\WakasekModel;
use App\Models\LembagaModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class Wakasek extends BaseController
{
    function __construct()
     {
        $this->gurumodel = new GuruModel();
        $this->wakasekmodel = new WakasekModel();
        $this->lembagamodel = new LembagaModel();
     }
    public function index()
    {
        // if(userlevel()->jabatan=='Operator'){
            $data['title'] ='Daftar Wakil Kepala Sekolah (Wakasek)';
            $data['guru']  = $this->gurumodel->where('is_active',1)->findAll();
            if(in_array('Administrator',userLevel())){
                $data['lembaga']  = $this->lembagamodel->findAll();
            }elseif(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel())) {
                    $data['lembaga']  = $this->lembagamodel->getLembaga(session('id_guru'));
            }

            return view('page/wakasek',$data);
        // }else{
        //     return redirect()->to(base_url('home'));
        // }
    }
    public function insert()
    {
        if($this->request->isAjax())
        {
            $output['csrf']     = csrf_hash();
            $uuid = Uuid::uuid4()->toString();
            $data = [
                'id_wakasek' => $uuid,
                'jabatan'    => $this->request->getVar('jabatan'),
                'id_guru'    => $this->request->getVar('guru'),
                'id_lembaga'    => $this->request->getVar('lembaga'),
                'id_tahun'   => tahunajar()->id_tahun,
                'is_active'  => 1,
                'tarik'  => 0,
            ];
            $save = $this->wakasekmodel->insert($data);
            // if($save){
            //     return $this->response->setStatusCode(200)->setJSON($output);
            // }
            return $this->response->setJSON($output);
        }
    }
    public function get()
    {
        if($this->request->isAjax()){
            if(in_array('Administrator',userLevel())){
                $builder = $this->wakasekmodel->getWakasek(['id_tahun'=>tahunajar()->id_tahun]);
            }else{
                $builder = $this->wakasekmodel->getWakasek(['id_tahun'=>tahunajar()->id_tahun,'wakasek.id_lembaga'=>jenjang()->id_lembaga]);
            }
            return DataTable::of($builder)->addNumbering('nomor')->toJson(true);
        }
    }
}
