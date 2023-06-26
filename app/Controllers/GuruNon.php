<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;
use \App\Models\GuruModel;
use \App\Models\BerkasGuruModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class GuruNon extends BaseController
{
    function __construct()
     {
        $this->gurumodel = new GuruModel();
        $this->berkasgurumodel = new BerkasGuruModel();
     }
    public function index()
    {
        {
            $data = [
                'title' => 'Daftar Guru Tidak Aktif',
            ];
            return view('page/gurunon',$data);
        }
    }
    public function uploadBerkas()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'namaberkas'=>[
                    'label' => 'Nama Berkas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi'
                        ]
                    ],
                'fileberkas' =>[
                    'label' => 'File Berkas',
                    'rules' => 'uploaded[fileberkas]|max_size[fileberkas,5024]',
                    'errors'=>[
                        'uploaded' => 'Berkas Belum dipilih',
                        'max_size' => 'Berkas Terlalu Besar Maksimal 5 MB'
                        ]
                    ]
                ]);
            if(!$valid){
                $msg = [
                    'error'=>[
                        'namaberkas' => $validation->getError('namaberkas'),
                        'fileberkas' => $validation->getError('fileberkas')
                    ]
                    ];
            }else{
                $nama = $this->request->getVar('namaberkas');
                $foto = $this->request->getFile('fileberkas');
                $sampul = $nama.'-'.userlogin()->nama.'-'.$foto->getRandomName();
                $foto->move('assets/berkas/guru/',$sampul);
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_berkas' => $uuid,
                    'id_guru' => userLogin()->id_guru,
                    'nama_berkas' => $nama,
                    'file_berkas' => $sampul
                ];
                $save = $this->berkasgurumodel->insert($data);
                    if($save){
                        $msg = [
                            'suksess' => 'Berhasil Disimpan'
                        ];
                    }
            }
            echo json_encode($msg);
        }
    }
    public function getData()
    {
        if($this->request->isAjax())
        {
            $builder = $this->db->table('guru')
                                ->select('id_guru, nama,jenis_kelamin, tempat_lahir,tgl_lahir,email,foto')
                                ->where('is_active','0');
            return DataTable::of($builder)
                            ->addNumbering('nomor')->toJson(true);
        }
    }
    public function active()
    {
        if($this->request->isAjax()){
            $id = $this->request->getVar('id');
            $data = [
                'is_active'=> '1',
            ];
            $save = $this->gurumodel->update($id, $data);
        }
    }
    public function upload()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\Services::validation();
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
                        'foto' => $validation->getError('foto'),
                    ]
                    ];
            }else{
                $foto = $this->request->getFile('foto');
                $sampul = $foto->getRandomName();
                $foto->move('assets/img/avatar/',$sampul);
                if(userLogin()->foto !='user.jpg'){
                    unlink('assets/img/avatar/'.userLogin()->foto);
                }
                $data =['foto'=> $sampul];
                $save = $this->gurumodel->update(session('id_guru'), $data);
                if($save){
                    $msg= [
                        'sukses' => 'Upload Berhasil'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    public function updatePassword()
    {
        if($this->request->isAjax())
        {
            $validation = \config\Services::validation();
            $valid = $this->validate([
                'passwordlama' => [
                    'label' => 'Password Lama',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} Harus Di isi',
                        ]
                    ],
                'passwordbaru' => [
                    'label' => 'Password Baru',
                    'rules' => 'trim|required',
                    'errors' =>[
                        'required' => '{field} Harus Di isi',
                        ]
                    ],
                'konfirmasi' => [
                    'label' => 'Konfirmasi Password',
                    'rules' => 'trim|required|matches[passwordbaru]',
                    'errors' =>[
                        'required' => '{field} Harus Di isi',
                        'matches'  => '{field} Tidak Sama dengan Password Baru',
                        ]
                    ],
                ]);
                $cek = password_verify($this->request->getVar('passwordlama'),userLogin()->password);
                if(!$valid)
                {
                    $msg = [
                        'error' =>[
                            'passwordLama' => $validation->getError('passwordlama'),
                            'passwordBaru' => $validation->getError('passwordbaru'),
                            'konfirmasi' => $validation->getError('konfirmasi'),
                        ]
                        ];
                }else{
                    if($cek)
                    {
                        $data = [
                            'password' => password_hash($this->request->getVar('passwordbaru'),PASSWORD_DEFAULT)
                        ];
                        $save = $this->gurumodel->update(session('id_guru'), $data);
                        if($save){
                            $msg = [
                                'suksess' => 'Berhasil Disimpan'
                            ];
                        }else{
                            $msg = [
                                'gagal' => 'Password Gagal'
                            ];

                        }
                    }else{
                        $msg = [
                            'error' =>[
                            'passwordSalah' => 'Password Lama Anda Salah'
                            ]
                        ];
                        
                    }
                }
                
                echo json_encode($msg);

        }
    }
    public function update()
    {
        if($this->request->isAjax()){
            $validation = \Config\Services::validation();
            if($this->request->getVar('nik') == userLogin()->nik)
            {
                $rulesNik = 'required';
            }else{
                $rulesNik = 'required|is_unique[guru.nik]';

            }
            if($this->request->getVar('email') == userLogin()->email)
            {
                $rulesEmail = 'required';
            }else{
                $rulesEmail = 'required|is_unique[guru.email]';

            }
            $valid = $this->validate([
                'nik' => [
                    'label' => 'No Nik',
                    'rules' => $rulesNik,
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
                        'rules' => $rulesEmail,
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
                    $data = [
                        'nik' => $this->request->getVar('nik'),
                        'nama' => $this->request->getVar('nama'),
                        'jenis_kelamin' => $this->request->getVar('jk'),
                        'tempat_lahir' => $this->request->getVar('tmp'),
                        'tgl_lahir' => $this->request->getVar('tgl'),
                        'email' => $this->request->getVar('email'),
                        'no_hp' => $this->request->getVar('nohp'),
                        'alamat' => $this->request->getVar('alamat'),
                        'desa' => $this->request->getVar('desa'),
                        'kecamatan' => $this->request->getVar('kecamatan'),
                        'kabupaten' => $this->request->getVar('kabupaten'),
                        'provinsi' => $this->request->getVar('provinsi'),
                    ];
                    $save = $this->gurumodel->update(session('id_guru'), $data);
                    if($save){
                        $msg = [
                            'suksess' => 'Berhasil Disimpan'
                        ];
                    }
                }
                echo json_encode($msg);
        }
    }
    public function deleteBerkas()
    {
        if($this->request->isAjax())
        {
            $file = $this->request->getVar('file');
            $id = $this->request->getVar('id');
            if(unlink('assets/berkas/guru/'.$file))
            {
               $delete = $this->berkasgurumodel->delete($id);
                if($delete){
                    $msg = [
                        'sukses' => 'Berhasil'
                    ];
                }
            }
                
            echo json_encode($msg);
        }
    }
    public function export()
    {
            $guru = $this->gurumodel->where('is_active', 1)->findAll();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'DAFTAR GURU SMK IT RAUDHATUL ULUUM');
            $sheet->setCellValue('A2', 'Tahun Pelajaran '.tahunajar()->tahunpelajaran);
            $sheet->mergeCells('A1:H1');
            $sheet->mergeCells('A2:H2');
            $sheet->setCellValue('A3', 'No');
            $sheet->setCellValue('B3', 'NIK');
            $sheet->setCellValue('C3', 'Nama');
            $sheet->setCellValue('D3', 'JK');
            $sheet->setCellValue('E3', 'Tempat Lahir');
            $sheet->setCellValue('F3', 'Tgl Lahir');
            $sheet->setCellValue('G3', 'Email');
            $sheet->setCellValue('H3', 'No HP');
            $column = 4;
            foreach ($guru as $key => $value) {
                if($value->jenis_kelamin=='L'){
                    $jk = 'Laki-Laki';
                }else{
                    $jk = 'Perempuan';
                }
                $sheet->setCellValue('A'.$column, ($column-1));
                $sheet->setCellValue('B'.$column, $value->nik);
                $sheet->setCellValue('C'.$column, $value->nama);
                $sheet->setCellValue('D'.$column, $jk);
                $sheet->setCellValue('E'.$column, $value->tempat_lahir);
                $sheet->setCellValue('F'.$column, $value->tgl_lahir);
                $sheet->setCellValue('G'.$column, $value->email);
                $sheet->setCellValue('H'.$column, $value->no_hp);
                $column ++;
            }
            $sheet->getStyle('A1:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000'],
                    ],
                ],
            ];
    
            $sheet->getStyle('A3:H'.($column-1))->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data Guru.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
        
    }
}
