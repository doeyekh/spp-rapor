<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LembagaModel;
use App\Models\SuratModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class Surat extends BaseController
{
    function __construct()
    {
        $this->lembagamodel = new LembagaModel();
        $this->suratmodel = new SuratModel();
    }
    public function index()
    {
        //
    }
    public function SuratMasuk()
    {
        $data['title'] = 'Surat Masuk';
        $data['sekolah'] = $this->lembagamodel->getsekolah(['id_jenjang'=> jenjang()->id_jenjang,'status'=> 1]);
        return view('page/surat-masuk',$data);
    }
    public function SuratKeluar()
    {
        $data['title'] = 'Surat Keluar';
        $data['sekolah'] = $this->lembagamodel->getsekolah(['id_jenjang'=> jenjang()->id_jenjang,'status'=> 1]);
        return view('page/surat-keluar',$data);
    }
    public function getSuratKeluar()
    {
        if($this->request->isAjax()){

            $builder = $this->suratmodel->getSurat(['surat.jenis_surat'=> 'Keluar']);
            return DataTable::of($builder)->addNumbering('nomor')
            ->filter(function ($builder, $request) {
            
                    
                if ($request->lembaga)
                    $builder->where('surat.id_lembaga', $request->lembaga);
                if ($request->thn)
                    $builder->where('surat.id_tahun', $request->thn);
                
            })->toJson(true);
        }
        
    }
    public function getSuratMasuk()
    {
        if($this->request->isAjax()){

            $builder = $this->suratmodel->getSurat(['surat.jenis_surat'=> 'Masuk']);
            return DataTable::of($builder)->addNumbering('nomor')
            ->filter(function ($builder, $request) {
            
                    
                if ($request->lembaga)
                    $builder->where('surat.id_lembaga', $request->lembaga);
                if ($request->thn)
                    $builder->where('surat.id_tahun', $request->thn);
                
            })->toJson(true);
        }
        
    }
    public function Upload()
    {
        if($this->request->isAjax())
        {
            $valid = $this->validate([
                'fileupload' => [
                    'label' => 'File',
                    'rules' => 'uploaded[fileupload]',
                    'errors' => [
                        'uploaded' => 'Harap Pilih File Terlebih Dahulu',
                    ]
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'file' => $this->validation->getError('file')
                    ]
                    ];
            }else{
                $upload = $this->request->getFile('fileupload');
                $sampul = $upload->getRandomName();
                if($upload->move('assets/berkas/surat/',$sampul)){
                    if($this->suratmodel->update($this->request->getVar('idsurat'),['file_surat'=> $sampul]))
                        {
                            $msg = ['sukses'=> 'Berhasil'];
                        }
                }
                
            }
            echo json_encode($msg);
        }
    }
    public function Insert()
    {
        if($this->request->isAjax())
        {
            $valid = $this->validate([
                'lembaga' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harap Pilih {Field} Lembaga Terlebih Dahulu'
                    ]
                    ],
                'nosurat' => [
                    'label' => 'No Surat',
                    'rules' => 'required|is_unique[surat.no_surat]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => 'No Sudah Terdaftar Silahkan Masukan No Lain'
                    ]
                    ],
                'perihal' => [
                    'label' => 'Perihal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                    ],
                'tujuan' => [
                    'label' => 'Tujuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'lembaga' => $this->validation->getError('lembaga'),
                        'nosurat' => $this->validation->getError('nosurat'),
                        'perihal' => $this->validation->getError('perihal'),
                        'tujuan' => $this->validation->getError('tujuan')
                    ]
                    ];
            }else{
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_surat' => $uuid,
                    'id_lembaga' => $this->request->getVar('lembaga'),
                    'id_tahun' => \tahunajar()->id_tahun,
                    'jenis_surat' => $this->request->getVar('jenis'),
                    'no_surat' => $this->request->getVar('nosurat'),
                    'perihal_surat' => $this->request->getVar('perihal'),
                    'tujuan' => $this->request->getVar('tujuan'),
                    'tgl_surat' => \tgl_indo(date('Y-m-d')),
                    'ket_surat' => $this->request->getVar('ket')
                ];
                if($this->suratmodel->insert($data)){
                    $msg = ['sukses'=> 'Berhasil'];
                }
            }
            echo json_encode($msg);
        }
    }
}
