<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegisterSiswa;
use App\Models\AlumniModel;
use App\Models\AnggotaRombelModel;
use App\Models\LembagaModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class RegistrasiSiswa extends BaseController
{
    function __construct()
    {
        $this->lembagamodel = new LembagaModel();
        $this->siswaregister = new RegisterSiswa();
        $this->alumni = new AlumniModel();
        $this->anggotarombel = new AnggotaRombelModel();
    }
    public function index()
    {
        $data ['title'] = 'Daftar Alumni/Lulus';
        $data ['alumni'] = $this->alumni->findAll();
        return view('page/siswaNon',$data);
    }
    public function getAlumni()
    {
        $builder = $this->alumni->getAlumni();
        return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
            if ($request->tahun)
                $builder->like('alumni.created_at', $request->tahun);
            if ($request->lembaga)
                $builder->where('alumni.id_lembaga',$request->lembaga);
        })->toJson(true);
    }
    public function getSiswa()
    {
        
        $builder = $this->db->table('siswa')->select('id_siswa,nisn,nama_siswa,jenis_kelamin');
        return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
        })->toJson(true);
    }
    public function UpdateStatusDapo()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('checkbox_value');
            $jml = count($id);
            $total = 0;
            for($i = 0; $i < $jml ; $i++)
            {
               if($this->db->table('registrasi')->where(['id_siswa' => $id[$i]])->update(['status' => 1 ]))
               {
                $total++;
               }
            }
            echo $total;
        }
    }
    public function InsertRegistrasi()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('checkbox_value');
            $lmg = $this->request->getVar('lmg');
            $cek = $this->lembagamodel->getjenjang($lmg);
            $jml = count($id);
            $berhasil = $gagal = 0;
            for($i = 0; $i < $jml ; $i++)
            {
                $uuid = Uuid::uuid4()->toString();
               if($this->siswaregister->where(['id_siswa' => $id[$i],'id_jenjang' => $cek->id_jenjang])->get()->getRow())
               {
                $gagal++;
               }else{
                $data = [
                    'id_registrasi' =>$uuid,
                    'id_siswa' => $id[$i],
                    'id_lembaga'   => $lmg,
                    'id_jenjang'   => $cek->id_jenjang,
                    'id_tahun'   => tahunajar()->id_tahun,
                    'status' => '0',
                    'is_active' => '1'
                ];
                if($this->siswaregister->insert($data)){
                    $berhasil++;
                } 
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
    public function updatenipd()
    {
        if($this->request->isAjax())
        {
            $where = ['id_siswa'=>$this->request->getVar('idsiswa'),'id_tahun'=>tahunajar()->id_tahun];
            $data = ['nipd'=> $this->request->getVar('nipd')];
            if($this->siswaregister->update($where,$data))
            {
                $pesan = ['sukses'=>'Berhasil'];
            }
            echo json_encode($pesan);
        }
    }
    public function insertAlumni()
    {
        if($this->request->isAjax())
        {
            $data = [
                'id_alumni' => Uuid::uuid4()->toString(),
                'id_siswa' => $this->request->getVar('id'),
                'id_tahun' => tahunajar()->id_tahun,
                'id_lembaga' => $this->request->getVar('idlembaga'),
                'jenis_alumni' => $this->request->getVar('jenis'),
                'alasan' => $this->request->getVar('alasan'),
                'pindahke' => $this->request->getVar('tujuan'),
            ];
            if($this->alumni->insert($data))
            {
                $where = [
                    'id_registrasi'=>$this->request->getVar('idregistrasisiswa'),
                ];
                $dataa = ['is_active' => '0'];
                $this->siswaregister->update($where,$dataa);
                $id = [
                    'id_siswa' => $this->request->getVar('id'),
                    'kelas.id_tahun' => tahunajar()->id_tahun,
                    'kelas.id_lembaga' => $this->request->getVar('idlembaga')
                ];
                $pesan = $this->anggotarombel->getAnggota($id);
                $pid = ['id_kelas'=>$pesan->id_kelas,'id_siswa'=>$pesan->id_siswa];
                $did = ['is_active'=>'0'];
                if($this->db->table('anggotarombel')->where($pid)->update($did)){
                    $ambil = ['Pesan'=>'Berhasil'];
                }
            }
            
            echo json_encode($ambil);
        }
    }
}
