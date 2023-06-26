<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KurikulumModel;
use App\Models\JenjangModel;
use \Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class Kurikulum extends BaseController
{
    function __construct()
    {
        $this->jenjangmodel = new JenjangModel;
        $this->kurikulummodel = new KurikulumModel;
    }
    
    public function index()
    {
        $data = [
            'title' => 'Daftar Kurikulum',
            'jenjang' => $this->jenjangmodel->findAll()
        ];
        return view('page/kurikulum', $data);
    }
    public function Insert(){
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jenjang' =>[
                    'label' => 'Jenjang',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} Belum Dipilih'
                        ]
                    ],
                'nama' =>[
                    'label' => 'Nama Kurikulum',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} Tidak Boleh Kosong'
                        ]
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'jenjang' => $validation->getError('jenjang'),
                        'nama' => $validation->getError('nama'),
                        ]
                    ];
            }else{
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_kurikulum' => $uuid,
                    'id_jenjang' => $this->request->getVar('jenjang'),
                    'nama_kurikulum' => $this->request->getVar('nama'),
                    'is_active' => '1'
                ];
                $data2 = [
                    'id_jenjang' => $this->request->getVar('jenjang'),
                    'nama_kurikulum' => $this->request->getVar('nama'),
                ];
                if($this->request->getVar('id')==null){
                    $save = $this->kurikulummodel->insert($data);
                }else{
                    $save = $this->kurikulummodel->update($this->request->getVar('id'),$data2);

                }
                if($save){
                    $msg = [
                        'berhasil' => 'Sukses'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    public function get(){
        if($this->request->isAjax())
        {
            $builder = $this->kurikulummodel->getKurikulum();
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder,$request){
                if($request->jenjang)
                $builder->where('jenjang.id_jenjang', $request->jenjang);
            })->toJson(true);
        }
    }
    public function Update()
    {
        if($this->request->isAjax())
        {
            $get = $this->kurikulummodel->where('id_kurikulum',$this->request->getVar('id'))->first();
            echo json_encode($get);
        }
    }
}
