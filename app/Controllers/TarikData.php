<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\WakasekModel;
use App\Models\LembagaModel;
use App\Models\KelasModel;
use App\Models\AnggotaRombelModel;
use App\Models\RegisterSiswa;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;


class TarikData extends BaseController
{
    function __construct()
     {
        $this->gurumodel = new GuruModel();
        $this->wakasekmodel = new WakasekModel();
        $this->lembagamodel = new LembagaModel();
        $this->kelas = new KelasModel();
        $this->anggota = new AnggotaRombelModel();
        $this->register = new RegisterSiswa();
     }
    public function index()
    {
        //
    }
    public function wakasek()
    {
        if($this->request->isAjax()){
                $builder = $this->wakasekmodel->getWakasek(['id_tahun' => oldtahunajar()->id_tahun,'jabatan !='=>'Wali Kelas', 'tarik'=>'0']);
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
        
                
                if ($request->lembaga)
                    $builder->where('wakasek.id_lembaga', $request->lembaga);
                
            })->toJson(true);
        }
    }
    public function Lulus()
    {
        if($this->request->isAjax()){
                $builder = $this->wakasekmodel->getWakasek(['id_tahun' => oldtahunajar()->id_tahun, 'tarik'=>'0']);
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
        
                
                if ($request->lembaga)
                    $builder->where('wakasek.id_lembaga', $request->lembaga);
                
            })->toJson(true);
        }
    }

    public function TarikWakasek()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('checkbox_value');
            $jml = count($id);
            $berhasil = $gagal = 0;
            for($i = 0; $i < $jml ; $i++)
            {
                $uuid = Uuid::uuid4()->toString();
                $cek  = $this->wakasekmodel->where(['id_wakasek' => $id[$i]])->get()->getRow();
                $data = [
                    'id_wakasek' => $uuid,
                    'jabatan' => $cek->jabatan,
                    'id_guru' => $cek->id_guru,
                    'id_lembaga' => $cek->id_lembaga,
                    'id_tahun' => tahunajar()->id_tahun,
                    'is_active' => 1,
                    'tarik' => 0
                ];
                if($this->wakasekmodel->insert($data)){
                    $this->wakasekmodel->update($id[$i],['tarik'=>'1']);
                    $berhasil++;
                }else{
                    $gagal++;
                }
            }
            $msg = ['sukses'=>
                        [
                            'Berhasil' => $berhasil,
                            'gagal' => $gagal,
                        ] 
                    ];
            echo json_encode($msg);
        }
    }
    public function Kelas()
    {
        if($this->request->isAjax())
        {
            $valid = $this->validate([
                'oldkelas' => [
                    'label' => 'Kelas Tahun Sebelumnya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ],
                ],
                'oldtingkat' => [
                    'label' => 'Tingkat Kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ],
                ],
                'oldnama' => [
                    'label' => 'Nama Kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Wajib Diisi'
                    ],
                ],
                'oldwakel' => [
                    'label' => 'Wali Kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Wajib Diisi'
                    ],
                ],
            ]);
            if(!$valid) {
                $msg =[
                    'error' => [
                        'kelas' => $this->validation->getError('oldkelas'),
                        'tingkat' => $this->validation->getError('oldtingkat'),
                        'nama' => $this->validation->getError('oldnama'),
                        'wakel' => $this->validation->getError('oldwakel'),
                        ]    
                ];
            }else{
                $cek = $this->kelas->where('id_kelas',$this->request->getVar('oldkelas'))->first();
                $cekanggota = $this->anggota->where(['id_kelas'=>$this->request->getVar('oldkelas'),'is_active'=>'1'])->findAll();
                $namakelas = $this->request->getVar('oldnama');
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_kelas' => $uuid,
                    'id_jenjangkelas' => $this->request->getVar('oldtingkat'),
                    'id_lembaga' => $cek->id_lembaga,
                    'id_kurikulum' => $cek->id_kurikulum,
                    'id_guru' => $this->request->getVar('oldwakel'),
                    'id_tahun' => \tahunajar()->id_tahun,
                    'nama_kelas' => $this->request->getVar('oldnama'),
                    'is_active' => '1',
                    'tarik' => '0',
                    ];
                    $wakasek = [
                        'id_wakasek' => $uuid,
                        'jabatan' => 'Wali Kelas',
                        'id_guru' => $this->request->getVar('oldwakel'),
                        'id_lembaga' => $cek->id_lembaga,
                        'id_tahun' => \tahunajar()->id_tahun,
                        'is_active' => '1',
                        'tarik' => '0'
                    ];
                if($this->kelas->insert($data))
                {
                    $this->wakasekmodel->insert($wakasek);
                    $this->kelas->update($this->request->getVar('oldkelas'),['tarik'=>'1']);
                    foreach($cekanggota as $ianggota){
                        $regiscek = $this->register->where([
                            'is_active'=> '1',
                            'id_lembaga' => $cek->id_lembaga,
                            'id_tahun'=>$cek->id_tahun,
                            'id_siswa'=>$ianggota->id_siswa
                        ])->findAll();
                        
                        $data2 = [
                            'id_anggotarombel' => Uuid::uuid4()->toString(),
                            'id_kelas' => $uuid,
                            'id_siswa' => $ianggota->id_siswa,
                            'is_active' => '1',
                            'tarik' => '0',
                        ];
                        $save = $this->anggota->insert($data2);   
                        foreach($regiscek as $nipd){
                            $adregister = $this->register->insert([
                                    'id_registrasi' => Uuid::uuid4()->toString(),
                                    'id_siswa' => $nipd->id_siswa,
                                    'nipd' => $nipd->nipd,
                                    'kelas' => $namakelas,
                                    'id_tahun' => \tahunajar()->id_tahun,
                                    'id_lembaga' => $nipd->id_lembaga,
                                    'id_jenjang' => $nipd->id_jenjang,
                                    'status' => $nipd->status,
                                    'is_active' => '1',
                                    'tarik' => '0'
                                ]);
                                $this->register->update($nipd->id_registrasi,['tarik'=>'1']);
                        } 
                    }
                    if($save){
                        $this->anggota->update($this->request->getVar('oldkelas'),['tarik'=>'1']);
                        $msg = ['sukses'=>'Berhasil'];
                    }
                }
                
            }
            echo json_encode($msg);
        }
    }
}
