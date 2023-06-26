<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\BerkasSiswaModel;
use \Hermawan\DataTables\DataTable;

class BerkasSiswa extends BaseController
{
    function __construct()
    {
        $this->berkas = new BerkasSiswaModel();
    }
    public function index()
    {
        $data ['title'] = 'Berkas Administrasi Persyaratan Siswa';
        return view('page/berkas-siswa',$data);
    }
    public function getData()
    {
        if($this->request->isAjax())
        {
            $builder = $this->berkas->getData(['registrasi.id_tahun'=> \tahunajar()->id_tahun,'registrasi.is_active' => 1]);
            return DataTable::of($builder)->addNumbering('nomor')->filter(function ($builder, $request) {
                
                if ($request->lembaga)
                    $builder->where('registrasi.id_lembaga', $request->lembaga);
                
            })->toJson(true);
            
        }
    }
    public function upload($id)
    {
        if($this->request->isAjax())
        {
                $nama = $this->request->getVar('nama');
                $idberkas = $this->request->getVar('idsiswa');
                $cek = $this->berkas->where('id_berkassiwa',$id)->first();
                
                    $ijazah = $this->request->getFile($id);
                    $sampul = $id.'-'.$nama.'-'.$ijazah->getRandomName();
                    $ijazah->move('assets/berkas/siswa/'.$id,$sampul);
                    $data =[$id=> $sampul];
                    if($this->berkas->update($idberkas,$data))
                    {
                        $datacek = [
                            'sukses' => ['id'=>$id,'sampul'=> $sampul]
                        ] ;

                    }
                    echo json_encode($datacek);
                


        }
    }

    // public function upload()
    // {
    //     if (!$this->request->isAJAX()) {
    //         return;
    //     }

    //     $nama = $this->request->getVar('nama');
    //     $id = $this->request->getVar('idsiswa');
    //     $cek = $this->berkas->where('id_berkassiwa', $id)->first();

    //     $fields = ['ijazah', 'skhu', 'kk', 'akta', 'ktpayah', 'ktpibu'];
    //     foreach ($fields as $field) {
    //         $file = $this->request->getFile($field);
    //         if ($file->isValid() && !$file->hasMoved()) {
    //             $path = 'assets/berkas/siswa/' . $field . '/';
    //             $filename = $field . '-' . $nama . '-' . $file->getRandomName();
    //             $file->move($path, $filename);

    //             // if ($berkas->{$field} && file_exists($path . $berkas->{$field})) {
    //             //     unlink($path . $berkas->{$field});
    //             // }
    //             // if (property_exists($cek, 'skhun') && $cek->skhun != '') {
    //             //     unlink('assets/berkas/siswa/skhu/'.$cek->skhun);
    //             // }

    //             $data[$field] = $filename;
    //         }
    //     }

    //     if (isset($data)) {
    //         $this->berkas->update($id, $data);
    //         echo json_encode(['sukses' => 'Berhasil']);
    //     }
    // }
    public function getDataId()
    {
        $id = $this->request->getVar('id');
        $cek = $this->berkas->where('id_berkassiwa', $id)->first(); 
        echo json_encode($cek); 
    }



}
