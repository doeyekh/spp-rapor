<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;
use \App\Models\GuruModel;
use \App\Models\BerkasGuruModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Guru extends BaseController
{
    function __construct()
     {
        $this->gurumodel = new GuruModel();
        $this->berkasgurumodel = new BerkasGuruModel();
     }
    public function index()
    {
        $data = [
            'title' => 'Daftar Guru'
        ];
        return view('page/guru',$data);
    }
    public function getData()
    {
        if($this->request->isAjax()){
            if(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel())):
            $builder = $this->db->table('guru')
                                ->select('guru.id_guru, nama,jenis_kelamin, tempat_lahir,tgl_lahir,email,foto')
                                ->where('id_guru !=',session('id_guru'))
                                ->where('is_active','1');
            return DataTable::of($builder)
                            ->addNumbering('nomor')->add('action', function($row){
                                return 'operator';
                            })->toJson(true);
            else :
            $builder = $this->db->table('guru')
                                ->select('guru.id_guru, nama,jenis_kelamin, tempat_lahir,tgl_lahir,email,foto,')
                                ->where('id_guru',session('id_guru'));
            return DataTable::of($builder)
                            ->addNumbering('nomor')->add('action', function($row){
                                return 'wakasek';
                            })->toJson(true);
        endif;
            
        }
    }
    public function insertUpdate()
    {
        if($this->request->isAjax()){
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nik' => [
                    'label' => 'No Nik',
                    'rules' => 'required|is_unique[guru.nik]',
                    'errors' =>[
                        'required' => '{field} Harus Di isi',
                        'is_unique' => '{field} Sudah Terdaftar Silahkan Masukan No lain',
                    ]
                    ],
                'nama' => [
                    'label' => 'nama',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} Harus Di isi',
                    ]
                    ],
                'email' => [
                        'label' => 'email',
                        'rules' => 'required|is_unique[guru.email]',
                        'errors' =>[
                            'required' => '{field} Harus Di isi',
                            'is_unique' => '{field} Sudah Terdaftar Silahkan Masukan No lain',
                        ]
                        ],
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'nik' => $validation->getError('nik'),
                        'nama' => $validation->getError('nama'),
                        'email' => $validation->getError('email'),
                    ]
                    ];
                }else{
                    $uuid = Uuid::uuid4()->toString();
                    $data = [
                        'id_guru' => $uuid,
                        'nik' => $this->request->getVar('nik'),
                        'nama' => $this->request->getVar('nama'),
                        'jenis_kelamin' => $this->request->getVar('jk'),
                        'tempat_lahir' => $this->request->getVar('tmp'),
                        'tgl_lahir' => $this->request->getVar('tgl'),
                        'email' => $this->request->getVar('email'),
                        'no_hp' => $this->request->getVar('nohp'),
                        'password' => password_hash('12345',PASSWORD_DEFAULT),
                        'foto' => 'user.jpg',
                        'is_active' => 1
                    ];
                    $save = $this->gurumodel->insert($data);
                    if($save){
                        $msg = [
                            'suksess' => 'Berhasil Disimpan'
                        ];
                    }
                }
                echo json_encode($msg);
        }
    }
    public function resset()
    {
        if($this->request->isAjax()){
            $id = $this->request->getVar('id');
            $data = [
                'password'=> password_hash('12345',PASSWORD_DEFAULT),
            ];
            $save = $this->gurumodel->update($id, $data);
        }
    }
    public function nonActive()
    {
        if($this->request->isAjax()){
            $id = $this->request->getVar('id');
            $data = [
                'is_active'=> '0',
            ];
            $save = $this->gurumodel->update($id, $data);
        }
    }
    public function import()
    {
        if($this->request->isAjax()){
            
            $valid = $this->validate([
                'excel' => [
                    'label' => 'excel',
                    'rules' => 'uploaded[excel]|ext_in[excel,xls,xlsx]',
                    'errors' =>[
                        'uploaded' => '{field} Harus Di isi',
                        'ext_in' => '{field} Bukan File Excel'
                    ]
                    ],
                
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'excel' => $this->validation->getError('excel'),
                    ]
                    ];
                }else{
                    $file = $this->request->getFile('excel');
                    $extensi = $file->getClientExtension();
                    if($extensi == 'xls'){
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\xls();
                    }else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\xlsx();
                    }
                    $spreadsheet = $reader->load($file);
                    $guru = $spreadsheet->getActiveSheet()->toArray();
                    $sukses = $gagal = 0;
                    foreach($guru as $key => $value){
                        if($key == 0){
                            continue;
                        }
                        
                        $nik = $value[1];
                        $email = $value[6];
                        $uuid = Uuid::uuid4()->toString();
                        $data = [
                            'id_guru' => $uuid,
                            'nik' => $nik,
                            'nama' => ucwords(strtolower($value[2])),
                            'jenis_kelamin' => $value[3],
                            'tempat_lahir' => ucwords(strtolower($value[4])),
                            'tgl_lahir' => $value[5],
                            'email' => strtolower($email),
                            'no_hp' => $value[7],
                            'password' => password_hash('12345',PASSWORD_DEFAULT),
                            'foto' => 'user.jpg',
                            'is_active' => 1
                        ];
                        $where = "nik='$nik' OR email='$email'";
                        $query = $this->db->table('guru')->getWhere($where);
                        if($query->getRow())
                        {
                            $gagal++;
                        }else{
                            $save = $this->gurumodel->insert($data);
                            $sukses++;
                        }
                    }
                    $msg = ['sukses'=>
                        [
                            'Berhasil' => $sukses,
                            'gagal' => $gagal,
                        ] 
                    ];
                }
                echo json_encode($msg);
        }
    }
    public function edit()
    {
        $data = [
            'title'=>'Profil',
            'berkas' => $this->berkasgurumodel->getBerkas(session('id_guru'))
        ];
        return view('page/profil',$data);
    }
}
