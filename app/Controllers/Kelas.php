<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\LembagaModel;
use App\Models\RegisterSiswa;
use App\Models\GuruModel;
use App\Models\KelasJenjangModel;
use App\Models\KelasModel;
use App\Models\KurikulumModel;
use App\Models\WakasekModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;


class Kelas extends BaseController
{
    function __construct()
    {
        $this->lembagamodel = new LembagaModel();
        $this->siswamodel = new SiswaModel();
        $this->siswaregister = new RegisterSiswa();
        $this->gurumodel = new GuruModel();
        $this->jenjangkelas = new KelasJenjangModel();
        $this->kurikulum = new KurikulumModel();
        $this->kelas = new KelasModel();
        $this->wakasekmodel = new WakasekModel();
    }
    public function index()
    {
        $data['title'] = 'Daftar Kelas';
        if(in_array('Administrator',userLevel())){
            $data['lembaga']  = $this->lembagamodel->getLembaga();
            $data['sekolah'] = $this->lembagamodel->getsekolah();
        }else
        if(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel()) || in_array('Koordinator',userLevel())) {
                $data['lembaga']  = $this->lembagamodel->getLembaga(session('id_guru'));
                $data['sekolah'] = $this->lembagamodel->getsekolah(jenjang()->id_jenjang);
            }
            $data['guru'] = $this->gurumodel->getGuru();
            $data['kurikulum'] = $this->kurikulum->findAll();
            $data['jenjang'] = $this->jenjangkelas->where('id_jenjang',jenjang(['wakasek.jabatan'=>'Operator'])->id_jenjang)->findAll();
            if(tahunajar()->smt == 'Ganjil') {
                if(\oldtahunajar() != ''){

                    $data['kelas'] = $this->kelas->getKelasData(['kelas.id_tahun'=>oldtahunajar()->id_tahun,'kelas.tarik'=>'0','jenjangkelas.tingkat_akhir'=>'0','id_lembaga'=>jenjang(['wakasek.jabatan'=>'Operator'])->id_lembaga])->findAll();
                }
            }else{
                if(\oldtahunajar() != ''){
                $data['kelas'] = $this->kelas->getKelasData(['kelas.id_tahun'=>oldtahunajar()->id_tahun,'kelas.tarik'=>'0','id_lembaga'=>jenjang(['wakasek.jabatan'=>'Operator'])->id_lembaga])->findAll();
                }
            }
        return view('page/kelas',$data);
    }
    public function Insert()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'lembaga' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                        ]
                    ],
                'tingkat' => [
                    'label' => 'tingkat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                        ]
                    ],
                'kurikulum' => [
                    'label' => 'kurikulum',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                        ]
                    ],
                'nama' => [
                    'label' => 'nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                        ]
                    ],
                ]);
            if(!$valid) {
                $msg =[
                    'error' => [
                        'lembaga' => $validation->getError('lembaga'),
                        'tingkat' => $validation->getError('tingkat'),
                        'kurikulum' => $validation->getError('kurikulum'),
                        'nama' => $validation->getError('nama'),
                        ]    
                ];
            }else{
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_kelas' => $uuid,
                    'id_lembaga' => $this->request->getVar('lembaga'),
                    'id_jenjangkelas' => $this->request->getVar('tingkat'),
                    'id_guru' => $this->request->getVar('wakel'),
                    'id_kurikulum' => $this->request->getVar('kurikulum'),
                    'nama_kelas' => $this->request->getVar('nama'),
                    'id_tahun' => tahunajar()->id_tahun,
                    'is_active' => 1,
                    'tarik' => '0'
                ];
                $data2 =[
                    'id_wakasek' => $uuid,
                    'jabatan' => 'Wali Kelas',
                    'id_guru' => $this->request->getVar('wakel'),
                    'id_lembaga' => $this->request->getVar('lembaga'),
                    'id_tahun' => tahunajar()->id_tahun,
                    'is_active' => 1
                ];
                    if($this->kelas->insert($data)){
                        $save = $this->wakasekmodel->insert($data2);
                        if($save){
                            $msg = ['sukses'=>'Berhasil'];
                        }
                    }    
            }
            echo json_encode($msg);
        }
    }
    public function Update()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('id');
            $get = $this->kelas->where('id_kelas',$id)->first();
            echo json_encode($get);
        }
    }
    public function getJenjang()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('data');
                $jenjang = $this->jenjangkelas->where('id_jenjang',$id)->get();
                if($jenjang->getNumRows() > 0 ) {

                    $kabupaten='<option value="">Semua</option>';
                }else{
                    $kabupaten='<option value="">Tidak Ada Data Kelas</option>';

                }
                foreach ($jenjang->getResultArray() as $data ){
                    $kabupaten.= "<option value='$data[id_jenjangkelas]'>$data[nama_tingkat]</option>";
                }
                return $kabupaten;
        }
    }
    public function getKurikulum()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('data');
                $jenjang = $this->kurikulum->where('id_jenjang',$id)->where('is_active',1)->get();
                if($jenjang->getNumRows() > 0 ) {

                    $kabupaten='<option value="">Semua</option>';
                }else{
                    $kabupaten='<option value="">Tidak Ada Data Kurikulum</option>';

                }
                foreach ($jenjang->getResultArray() as $data ){
                    $kabupaten.= "<option value='$data[id_kurikulum]'>$data[nama_kurikulum]</option>";
                }
                return $kabupaten;
        }
    }
    public function getData()
    {
        if($this->request->isAjax())
        {
            $builder = $this->kelas->getKelas();
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
                if ($request->lembaga)
                    $builder->where('kelas.id_lembaga', $request->lembaga);
            })->toJson(true);
        }
    }
}
