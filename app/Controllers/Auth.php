<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('login',$data);
    }

    public function login()
    {
        if($this->request->isAjax())
        {
            $validation = \Config\services::validation();
            $valid = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                        'valid_email' => 'Harap Masukan email'
                    ],
                    ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => '{field} Harus Diisi'
                    ],
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'email' => $validation->getError('email'),
                        'password' => $validation->getError('password'),
                    ]
                    ];
            }else{
                $post = $this->request->getPost();
                $query = $this->db->table('guru')->getWhere(['email' => $post['email']]);
                $user = $query->getRow();
                if($user){
                    
                    if(password_verify($post['password'],$user->password)){
                        $params = ['id_guru'=> $user->id_guru];
                        session()->set($params);
                        $msg= ['sukses'=>'Berhasil'];
                    }else{
                        $msg = [
                            'salahpassword' => 'Password Salah'
                        ]; 
                    }
                }else{
                    $msg = [
                        'salahemail' => 'Email Tidak Terdaftar'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
