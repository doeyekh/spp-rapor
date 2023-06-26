<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\LembagaModel;
use App\Models\RegisterSiswa;
use App\Models\BerkasSiswaModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Siswa extends BaseController
{
    function __construct()
    {
        $this->lembagamodel = new LembagaModel();
        $this->siswamodel = new SiswaModel();
        $this->siswaregister = new RegisterSiswa();
        $this->berkas = new BerkasSiswaModel();
    }
    public function index()
    {
        $data['title'] = 'Daftar Siswa';
        if(in_array('Administrator',userLevel())){
            $data['lembaga']  = $this->lembagamodel->getLembaga();
            $data['sekolah'] = $this->lembagamodel->getsekolah();
        }elseif(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel()) || in_array('Koordinator',userLevel())) {
                $data['lembaga']  = $this->lembagamodel->getLembaga(session('id_guru'));
                $data['sekolah'] = $this->lembagamodel->getsekolah(jenjang()->id_jenjang);
        }
        return view('page/siswa',$data);
    }
    public function ImportSiswa()
    {
        if($this->request->isAjax())
        {
            $valid = $this->validate([
                'excel' => [
                    'label' => 'File Excel',
                    'rules' => 'uploaded[excel]|ext_in[excel,xls,xlsx]',
                    'errors' =>[
                        'uploaded' => 'Tidak Ada File Yang DiUpload',
                        'ext_in' => '{field} Bukan File Excel'
                    ]
                    ],
                    'lmg' => [
                        'label' => 'Lembaga',
                        'rules' => 'required',
                        'errors' =>[
                            'required' => 'Lembaga Belum Dipilih'
                        ]
                    ]
            ]);
            if(!$valid)
            {
                $msg = [
                    'error' =>[
                        'excel' => $this->validation->getError('excel'),
                        'lmg' => $this->validation->getError('lmg'),
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
                    $siswa = $spreadsheet->getActiveSheet()->toArray();
                    $sukses = $gagal = 0;
                    foreach($siswa as $key => $value){
                        if($key == 0){
                            continue;
                        }
                        
                        $nisn = $value[1];
                        $nik = $value[3];
                        $uuid = Uuid::uuid4()->toString();
                        $data = [
                            'id_siswa' => $uuid,
                            'nisn' => $nisn,
                            'nik' => $nik,
                            'nama_siswa' => ucwords(strtolower($value[4])),
                            'jenis_kelamin' => $value[5],
                            'tempat_lahir' => ucwords(strtolower($value[6])),
                            'tgl_lahir' => $value[7],
                            'nama_ayah' => ucwords(strtolower($value[8])),
                            'nik_ayah' => $value[9],
                            'nama_ibu' => ucwords(strtolower($value[10])),
                            'nik_ibu' => $value[11],
                            'password' => password_hash('12345',PASSWORD_DEFAULT),
                            'foto' => 'siswa.jpg',
                        ];
                        $cek = $this->lembagamodel->getjenjang($this->request->getVar('lmg'));
                        $data2 = [
                            'id_registrasi' =>$uuid,
                            'id_siswa' => $uuid,
                            'id_lembaga'   => $this->request->getVar('lmg'),
                            'id_jenjang'   => $cek->id_jenjang,
                            'nipd' => $value[2],
                            'id_tahun'   => tahunajar()->id_tahun,
                            'status' => '0',
                            'is_active' => '1'
                        ];
                        $data3 = ['id_berkassiwa'=>$uuid,'id_siswa'=>$uuid];
                        $where = "nisn='$nisn' OR nik='$nik'";
                        $query = $this->db->table('siswa')->getWhere($where);
                        if($query->getRow())
                        {
                            $gagal++;
                        }else{
                            $save = $this->siswamodel->insert($data);
                            if($this->siswaregister->insert($data2)){
                                $this->berkas->insert($data3);
                                $sukses++;
                            } 
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
    public function insert()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nik' => [
                    'label' => 'nik',
                    'rules' => 'required|is_unique[siswa.nik]',
                    'errors' => [
                        'required' => '{field} Harus Di isi',
                        'is_unique' => '{field} Sudah Terdaftar Silahkan Masukan No lain',
                    ],
                ],
                'nisn' => [
                    'label' => 'nisn',
                    'rules' => 'required|is_unique[siswa.nisn]',
                    'errors' => [
                        'required' => '{field} Harus Di isi',
                        'is_unique' => '{field} Sudah Terdaftar Silahkan Masukan No lain',
                    ],
                ],
                'nama' => [
                    'label' => 'nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Di isi',
                    ],
                ],
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'nik' => $validation->getError('nik'),
                        'nisn' => $validation->getError('nisn'),
                        'nama' => $validation->getError('nama'),
                    ]
                    ];
            }else{
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_siswa' => $uuid,
                    'nik' => $this->request->getVar('nik'),
                    'nisn' => $this->request->getVar('nisn'),
                    'nama_siswa' => ucwords(strtolower($this->request->getVar('nama'))),
                    'jenis_kelamin' => $this->request->getVar('jk'),
                    'tempat_lahir' => $this->request->getVar('tmp'),
                    'tgl_lahir' => $this->request->getVar('tgl'),
                    'no_hp' => $this->request->getVar('nohp'),
                    'nama_ayah' => ucwords(strtolower($this->request->getVar('ayah'))),
                    'nama_ibu' => ucwords(strtolower($this->request->getVar('ibu'))),
                    'pekerjaan_ayah' => ucwords(strtolower($this->request->getVar('kerjaayah'))),
                    'pekerjaan_ibu' => ucwords(strtolower($this->request->getVar('kerjaibu'))),
                    'password' => password_hash('12345',PASSWORD_DEFAULT),
                    'foto' => 'siswa.jpg',
                ];
                $cek = $this->lembagamodel->getjenjang($this->request->getVar('lembaga'));
                $data2 = [
                    'id_registrasi' =>$uuid,
                    'id_siswa' => $uuid,
                    'id_lembaga'   => $this->request->getVar('lembaga'),
                    'id_jenjang'   => $cek->id_jenjang,
                    'id_tahun'   => tahunajar()->id_tahun,
                    'status' => '0',
                    'is_active' => '1'
                ];
                $data3 = ['id_berkassiwa'=>$uuid,'id_siswa'=>$uuid];
                $save = $this->siswamodel->insert($data);
                // if($save){
                if($this->siswaregister->insert($data2)){
                    $this->berkas->insert($data3);
                    $msg = [
                        'sukses' => 'Berhasil Disimpan'
                    ];
                } 
            }
            echo json_encode($msg);
        }
    }
    public function lembaga(){
        if($this->request->isAjax()){
            $id = $this->request->getVar('id');
            $kabupaten='<option value="">Semua</option>';
            foreach (userlembaga($id)->getResultArray() as $data ){
                $kabupaten.= "<option value='$data[id_lembaga]'>$data[nama_sekolah]</option>";
            }

            return $kabupaten;
        }
    }
    public function get()
    {
        if($this->request->isAjax()){
            $builder = $this->db->table('registrasi')
                  ->select('siswa.id_siswa,registrasi.kelas,nik, nama_siswa,nisn,jenis_kelamin,tempat_lahir,tgl_lahir,registrasi.nipd,registrasi.status')
                  ->join('siswa', 'siswa.id_siswa = registrasi.id_siswa')
                  ->where('registrasi.is_active ','1')
                  ->where('registrasi.id_tahun',tahunajar()->id_tahun);
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
        
                
                if ($request->lembaga)
                    $builder->where('registrasi.id_lembaga', $request->lembaga);
                
            })->toJson(true);
        }
    }
    public function detail($id)
    {
        
        $data =[
            'title' => 'Detail Profil Siswa',
            'siswa' => $this->siswamodel->getRegis(['siswa.id_siswa' => $id]),
        ];
        return view('page/siswa-detail',$data);
    }
    public function detailnipd()
    {
        if($this->request->isAjax())
        {
            $id = $this->request->getVar('id');
            echo json_encode($this->siswamodel->getRegis(['siswa.id_siswa' => $id]));
        }
        
    }
    public function updatelembaga($id)
    {
        if($this->request->isAjax())
        {
            $where = ['id_siswa'=>$id,'id_tahun'=>tahunajar()->id_tahun];
            $data = ['id_lembaga'=> $this->request->getVar('registrasi')];
            $this->siswaregister->update($where,$data);
            echo 'Berhasil';
        }
    }
    public function upload($id)
    {
        if($this->request->isAjax())
        {
            
            $valid = $this->validate([
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpeg]|ext_in[foto,png,jpg,gif]|is_image[foto]',
                    'errors' =>[
                        'uploaded' => '{field} Belum Dipilih',
                        'ext_in' => '{field} Bukan File Foto',
                        'mime_in' => 'Yang Anda Pilih Bukan File Foto',
                        'is_image' => '{field} Bukan Gambar',
                        'max_size' => 'Ukuran Foto Terlalu Besar',
                    ]
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'foto' => $this->validation->getError('foto'),
                    ]
                    ];
            }else{
                $foto = $this->request->getFile('foto');
                $sampul = $foto->getRandomName();
                $foto->move('assets/img/siswa/',$sampul);
                $siswa = $this->siswamodel->getRegis(['siswa.id_siswa' => $id]);
                if($siswa->foto !='siswa.jpg'){
                    unlink('assets/img/siswa/'.$siswa->foto);
                }
                $data =['foto'=> $sampul];
                $save = $this->siswamodel->update($id, $data);
                if($save){
                    $msg= [
                        'sukses' => 'Upload Berhasil'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    public function update($id)
    {
        if($this->request->isAjax())
        {
            $siswa = $this->siswamodel->getRegis(['siswa.id_siswa' => $id]);
            if($siswa->nisn == $this->request->getVar('nisn') )
            {
                $rulesnisn = 'required';
                $errornisn = ['required'=> '{field} Wajib Diisi'];
            }else{
                $rulesnisn = 'required|is_unique[siswa.nisn]';
                $errornisn = ['required'=> '{field} Wajib Diisi','is_unique' => 'Nisn Sudah Terdaftar'];
            }
            if($siswa->nik == $this->request->getVar('nik') )
            {
                $rulesnik = 'required';
                $errornik = ['required'=> '{field} Wajib Diisi'];
                
            }else{
                $rulesnik = 'required|is_unique[siswa.nik]';
                $errornik = ['required'=> '{field} Wajib Diisi','is_unique' => 'Nik Sudah Terdaftar'];
            }
            
            $valid = $this->validate([
                'nisn' => [
                    'label' => 'nisn',
                    'rules' => $rulesnisn,
                    'errors' => $errornisn,
                ],
                'nik' => [
                    'label' => 'Nik',
                    'rules' => $rulesnik,
                    'errors' => $errornik,
                ],
                'nama' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ],
            ]);
            if(!$valid){
                $msg = [
                    'error'=> [
                        'nisn' => $this->validation->getError('nisn'),
                        'nik' => $this->validation->getError('nik'),
                        'nama' => $this->validation->getError('nama')
                    ]
                ];
            }else{
                $data = [
                    'nisn' => $this->request->getVar('nisn'),
                    'nik' => $this->request->getVar('nik'),
                    'nama_siswa' => ucwords(strtolower($this->request->getVar('nama'))),
                    'tempat_lahir' => ucwords(strtolower($this->request->getVar('tempat'))),
                    'tgl_lahir' => $this->request->getVar('tgl'),
                    'alamat' => ucwords(strtolower($this->request->getVar('alamat'))),
                    'rt' => $this->request->getVar('rt'),
                    'rw' => $this->request->getVar('rw'),
                    'desa' => ucwords(strtolower($this->request->getVar('desa'))),
                    'kecamatan' => ucwords(strtolower($this->request->getVar('kecamatan'))),
                    'kabupaten' => ucwords(strtolower($this->request->getVar('kabupaten'))),
                    'provinsi' => ucwords(strtolower($this->request->getVar('provinsi'))),
                    'nama_ayah' => ucwords(strtolower($this->request->getVar('namaayah'))),
                    'nik_ayah' => ucwords(strtolower($this->request->getVar('nikayah'))),
                    'pekerjaan_ayah' => ucwords(strtolower($this->request->getVar('pekerjaanayah'))),
                    'nama_ibu' => ucwords(strtolower($this->request->getVar('namaibu'))),
                    'nik_ibu' => ucwords(strtolower($this->request->getVar('nikibu'))),
                    'pekerjaan_ibu' => ucwords(strtolower($this->request->getVar('pekerjaanibu'))),
                ];
                if($this->siswamodel->update($id,$data))
                {
                    $msg = ['Berhasil'];
                }
            }
           echo json_encode($msg); 
        }
    }
}
