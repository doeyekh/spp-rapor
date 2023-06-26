<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegisterSiswa;
use App\Models\AnggotaRombelModel;
use \Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class AnggotaRombel extends BaseController
{
    function __construct()
    {
        $this->registersiswa = new RegisterSiswa();
        $this->anggotarombel = new AnggotaRombelModel();
    }
    public function index()
    {
        //
    }
    public function getRegisterNon($lembaga){
        $data = [
            'kelas'=>'',
            'id_lembaga' => $lembaga,
            'registrasi.id_tahun' => \tahunajar()->id_tahun
        ];
        $builder = $this->registersiswa->getRegistrasi($data);
        return DataTable::of($builder)->addNumbering('nomor')->toJson(true);
    }
    public function getRegister($kelas,$lembaga){
        $data = [
            'kelas.id_kelas' => $kelas,
            'registrasi.id_lembaga' => $lembaga,
            'anggotarombel.is_active' => 1,
            'kelas.id_tahun' => \tahunajar()->id_tahun,
            'registrasi.id_tahun' => \tahunajar()->id_tahun,
        ];
        $builder = $this->anggotarombel->getRegister($data);
        return DataTable::of($builder)->addNumbering('nomor')->toJson(true);
    }
    public function Insert()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('checkbox_value');
            $kelas = $this->request->getVar('kelas');
            $nama = $this->request->getVar('nama');
            $lembaga = $this->request->getVar('lembaga');
            $jml = count($id);
            for($i = 0; $i < $jml ; $i++)
            {
                $uuid = Uuid::uuid4()->toString();
                $data=[
                    'id_anggotarombel' => $uuid,
                    'id_kelas' => $kelas,
                    'id_siswa' => $id[$i],
                    'is_active' => 1,
                    'tarik' => '0',
                ];
                $this->anggotarombel->insert($data);
                $this->db->table('registrasi')->where(['id_siswa' => $id[$i],'id_lembaga'=>$lembaga])->update(['kelas' => $nama ]);
            }
            echo 'berhasil';
        }
    }
    public function Delete()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('checkbox_value');
            $kelas = $this->request->getVar('kelas');
            $jml = count($id);
            for($i = 0; $i < $jml ; $i++)
            {
                $data=[
                    'id_kelas' => $kelas,
                    'id_siswa' => $id[$i]
                ];
                
                $this->db->table('anggotarombel')->where($data)->delete();
                $this->db->table('registrasi')->where(['id_siswa' => $id[$i]])->update(['kelas' => '' ]);
            }
            echo 'berhasil';
        }
    }
}
