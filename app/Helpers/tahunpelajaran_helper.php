<?php 
function alltahunajar()
{
    $db      = \Config\Database::connect(); 
    return $db->table('tahunajar')->get()->getResultArray();
}
function tahunajar()
{
    $db      = \Config\Database::connect(); 
    return $db->table('tahunajar')->getWhere(['status'=>1])->getRow();
}
function oldtahunajar()
{
    $db      = \Config\Database::connect();
    if(tahunajar()->smt == 'Ganjil'){
        $tl = tahunajar()->tahun ;
        return $db->table('tahunajar')->getWhere(['tahun'=> $tl ,'smt'=> 'Genap'])->getRow();
    }else{
        $tl = tahunajar()->tahun - 1;
        return $db->table('tahunajar')->getWhere(['tahun'=> $tl, 'smt'=>'Ganjil'])->getRow();
    } 
}
function userLogin(){
    $db      = \Config\Database::connect();
    return $db->table('guru')->where('id_guru', session('id_guru'))->get()->getRow();
}
function userLevel(){
    $db      = \Config\Database::connect();
     $cek = $db->table('wakasek')
            ->select('jabatan')
              ->where('id_guru', session('id_guru'))
              ->where('is_active',1)
              ->where('id_tahun',tahunajar()->id_tahun)->get()->getResultArray();
    if($cek)
    {
        for ($i=0; $i < count($cek); $i++) { 
            $c[$i] = $cek[$i]['jabatan']; 
          }
        return $c;
    }else{
         $jabatan = ['Guru'];
       return $jabatan;
        
    }
}
function jenjang($id=[]){
    $db      = \Config\Database::connect();
    return $db->table('wakasek')
                ->join('lembaga','lembaga.id_lembaga=wakasek.id_lembaga')
                ->where('wakasek.id_guru', session('id_guru'))
                ->where('wakasek.is_active',1)
                ->where($id)
                ->where('wakasek.id_tahun',tahunajar()->id_tahun)->get()->getRow();
}
function getLembaga($id=[]){
    $db      = \Config\Database::connect();
    return $db->table('lembaga')->where($id)->get();
}
function userjenjang(){
    $db      = \Config\Database::connect();
    return $db->table('wakasek')
                ->join('lembaga','lembaga.id_lembaga=wakasek.id_lembaga')
                ->where('wakasek.id_guru', session('id_guru'))
                ->where('wakasek.is_active',1)->get()->getResultArray();
}
function userlembaga($id){
    $db      = \Config\Database::connect();
    return $db->table('lembaga')
                ->where('id_jenjang',$id)->get();
}
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

?>