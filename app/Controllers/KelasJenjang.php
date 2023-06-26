<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use App\Models\JenjangModel;
use App\Models\KelasJenjangModel;
use \Hermawan\DataTables\DataTable;

class KelasJenjang extends BaseController
{
    function __construct()
    {
        $this->jenjangmodel = new JenjangModel;
        $this->kelasjenjangmodel = new KelasJenjangModel;
    }
    public function index()
    {
        $data = [
            'title' => 'Referensi Kelas Per Jenjang',
            'jenjang' => $this->jenjangmodel->findAll()
        ];
        return view('page/ref-kelas',$data);
    }
    public function update()
    {
        if($this->request->isAjax()){
            $id = $this->request->getVar('id');
            $data = $this->kelasjenjangmodel->where('id_jenjangkelas',$id)->first();
            echo json_encode($data);
        }
    }
    public function insert()
    {
        if($this->request->isAjax()){
            $validation = \Config\Services::validation();
            
            $valid = $this->validate([
                'nama' =>[
                    'label' => 'Nama Tingkat',
                    'rules' => 'required|is_unique[jenjangkelas.nama_tingkat]',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        'is_unique' => '{field} Sudah Terdaftar'
                        ]
                    ],
                'jenjang' =>[
                    'label' => 'Jenjang Tingkat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Wajib Diisi',
                        ]
                    ],
            ]);
            if($this->request->getVar('akhir')==true){
                $tingkat = '1';           
            }else{
                $tingkat = '0';           
            }
            $uuid = Uuid::uuid4()->toString();
            if(!$valid){
                $msg = [
                    'error' => [
                    'jenjang' => $validation->getError('jenjang'),
                    'nama' => $validation->getError('nama')
                    ]
                ];
            }else{
                $data = [
                    'id_jenjangkelas' => $uuid,
                    'id_jenjang' => $this->request->getVar('jenjang'),
                    'nama_tingkat' => $this->request->getVar('nama'),
                    'tingkat_akhir' => $tingkat
                ];
                $id = $this->request->getVar('idjenjang');
                $data2 = [
                    'id_jenjang' => $this->request->getVar('jenjang'),
                    'nama_tingkat' => $this->request->getVar('nama'),
                    'tingkat_akhir' => $tingkat
                ];
                if($this->request->getVar('idjenjang')==null){
                    $save = $this->kelasjenjangmodel->insert($data);
                }else{
                    $save = $this->kelasjenjangmodel->update($id,$data2);
                }
                if($save){
                    $msg = [
                        'berhasil' => 'Berhasil'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    public function get()
    {
        if($this->request->isAjax())
        {
            $builder = $this->kelasjenjangmodel->getJenjang();
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request){
                if ($request->jenjang)
                    $builder->where('jenjang.id_jenjang', $request->jenjang);
                
            })->toJson(true);
        }
    }
}
