<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class TahunAjar extends BaseController
{
    public function index()
    {
        if(date('m') > 6 ){
            $tahun = date('Y') .'/' . date('Y')+1;
            $smt = 'Ganjil';
        }else{
            $tahun = date('Y')-1 .'/' . date('Y');
            $smt = 'Genap';
          }
        $data =[
            'title' => 'Tahun Pelajaran',
            'tahun' => $tahun,
            'smt'   => $smt
        ];
        return view('page/tahun-ajar',$data);
    }
    public function save()
    {
        if($this->request->isAjax()){
            $uuid = Uuid::uuid4()->toString();
            $tahun = date('Y');
            $tahunpel = $this->request->getVar('tahun');
            $smt = $this->request->getVar('smt');
            $query = $this->db->table('tahunajar')->getWhere(['tahun' => $tahun,'tahunpelajaran'=>$tahunpel,'smt'=>$smt]);
            if($query->getRow())
            {
                echo 1;
                die;
            }
            $data = [
                'id_tahun' =>$uuid,
                'tahun' => $tahun,
                'tahunpelajaran' => $tahunpel,
                'smt' => $smt,
                'status' => 2,
                'created_at'    => \CodeIgniter\I18n\Time::now(),
                'updated_at'    => \CodeIgniter\I18n\Time::now(),
            ];
           $save =  $this->db->table('tahunajar')->insert($data);
          
        }
    }
    public function get()
    {
        if($this->request->isAjax()){
            $builder = $this->db->table('tahunajar')->select('id_tahun, tahunpelajaran,smt, status');
            return DataTable::of($builder)->addNumbering('nomor')->toJson(true);
        }
    }
    public function updateStatus()
    {
        if($this->request->isAjax()){
            $id = $this->request->getVar('idtahun');
            $status = $this->request->getVar('status');
            
                $data =[
                    'status' =>2
                ];
                $this->db->table('tahunajar')->update($data);
                $aktif = [
                    'status' =>1,
                    'updated_at'    => \CodeIgniter\I18n\Time::now(),
                ];
                $this->db->table('tahunajar')->where(['id_tahun' => $id])->update($aktif);
                $this->db->table('wakasek')->where(['jabatan' => 'Administrator'])->update(['id_tahun' => $id]);
           
        }
    }
}
