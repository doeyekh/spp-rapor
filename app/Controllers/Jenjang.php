<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenjangModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class Jenjang extends BaseController
{
    function __construct()
    {
        $this->jenjangmodel = new JenjangModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Jenjang'
        ];
        return view('page/jenjang',$data);
    }
    public function get()
    {
        if($this->request->isAjax())
        {
            $builder = $this->db->table('jenjang')
                                ->select('id_jenjang, nama,status');
            return DataTable::of($builder)
                            ->addNumbering('nomor')->toJson(true);
        }
    }
    public function insert()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required|is_unique[jenjang.nama]',
                    'errors' => [
                        'required' => '{field} Harus Di isi',
                        'is_unique' => '{field} Sudah Terdaftar Silahkan Masukan No lain',
                    ],
                ]
                ]);
                if(!$valid)
                {
                    $msg = [
                        'error' =>[
                            'nama' => $validation->getError('nama'),
                        ]
                        ];
                }else{
                    $uuid = Uuid::uuid4()->toString();
                    $data = [
                        'id_jenjang' => $uuid,
                        'nama' => $this->request->getVar('nama'),
                        'status' => $this->request->getVar('jenis'),
                    ];
                    $save = $this->jenjangmodel->insert($data);
                    if($save){
                        $msg = [
                            'sukses' => 'Berhasil Disimpan'
                        ];
                    } 
                }
                echo json_encode($msg);
        }
    }
}
