<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('create-db', function(){
    $forge = \Config\Database::forge();
    if ($forge->createDatabase('e-spp')) {
        echo 'Database created!';
    }
});
$routes->addRedirect('/','home');
$routes->get('/home', 'Home::index');
$routes->get('tahun-ajar', 'TahunAjar::index');
$routes->post('/tahun-ajar', 'TahunAjar::save');
$routes->get('/tahunajar', 'TahunAjar::get');
$routes->post('/tahunpelajaran', 'TahunAjar::updateStatus');

$routes->get('/guru-ak', 'Guru::index');
$routes->get('/guruget', 'Guru::getData');
$routes->post('/guru', 'Guru::insertUpdate');
$routes->PUT('/guru', 'Guru::resset');
$routes->DELETE('/guru', 'Guru::nonActive');
$routes->post('/guru/import', 'Guru::import');
$routes->post('/guru/upload', 'GuruNon::upload');

$routes->get('/guru-non', 'GuruNon::index');
$routes->get('/guru', 'GuruNon::getData');
$routes->DELETE('/guru-ak', 'GuruNon::active');
$routes->get('/guru/download', 'GuruNon::export');

$routes->get('/kelas', 'Kelas::index');

$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/wakasek', 'Wakasek::index');
$routes->post('/wakasek', 'Wakasek::insert');
$routes->get('/wakasekget', 'Wakasek::get');


$routes->get('/siswa-ak', 'Siswa::index');
$routes->PUT('/siswa-ak', 'Siswa::detailnipd');
$routes->get('/siswa/(:any)', 'Siswa::detail/$1');
$routes->get('/siswa', 'Siswa::get');
$routes->post('/siswa', 'Siswa::insert');
$routes->PUT('/getlembaga', 'Siswa::lembaga');
$routes->post('/siswa/(:any)', 'Siswa::Upload/$1');
$routes->post('/updateregister/(:any)', 'Siswa::updatelembaga/$1');
$routes->PUT('/siswa/(:any)', 'Siswa::update/$1');
$routes->PUT('/siswa', 'Siswa::ImportSiswa');

$routes->post('/register', 'RegistrasiSiswa::updatenipd');
$routes->post('/alumni', 'RegistrasiSiswa::insertAlumni');
$routes->get('/alumni', 'RegistrasiSiswa::getAlumni');
$routes->get('/siswa-tarik', 'RegistrasiSiswa::getSiswa');
$routes->post('/statusdapo', 'RegistrasiSiswa::UpdateStatusDapo');
$routes->post('/tarikregister', 'RegistrasiSiswa::InsertRegistrasi');

$routes->get('/siswa-non', 'RegistrasiSiswa::index');

$routes->get('/berkas', 'BerkasSiswa::index');
$routes->get('/berkasget', 'BerkasSiswa::getData');
$routes->PUT('/berkasget', 'BerkasSiswa::getDataId');
$routes->post('/berkas/(:any)', 'BerkasSiswa::Upload/$1');


$routes->PUT('/getJenjang', 'Kelas::getJenjang');
$routes->PUT('/getKurikulum', 'Kelas::getKurikulum');
$routes->post('/kelas', 'Kelas::Insert');
$routes->get('/kelasget', 'Kelas::getData');
$routes->PUT('/kelas', 'Kelas::Update');

$routes->get('/getrombelnon/(:any)', 'AnggotaRombel::getRegisterNon/$1');
$routes->get('/getrombel/(:any)/(:any)', 'AnggotaRombel::getRegister/$1/$2');
$routes->post('/rombel', 'AnggotaRombel::Insert');
$routes->PUT('/rombel', 'AnggotaRombel::Delete');

$routes->get('/lembaga', 'Lembaga::index');
$routes->post('/lembaga', 'Lembaga::insert');
$routes->get('/lembagaget', 'Lembaga::get');
$routes->get('/jenjang', 'Jenjang::index');
$routes->post('/jenjang', 'Jenjang::insert');

$routes->get('/jenjangget', 'Jenjang::get');
$routes->get('/ref-kelas', 'KelasJenjang::index');
$routes->post('/refkelas', 'KelasJenjang::update');
$routes->post('/ref-kelas', 'KelasJenjang::insert');
$routes->get('/refkelas', 'KelasJenjang::get');

$routes->get('/profil', 'Guru::edit');
$routes->post('/profile', 'GuruNon::update');
$routes->post('/password', 'GuruNon::updatePassword');
$routes->post('/berkasguru', 'GuruNon::uploadBerkas');
$routes->DELETE('/profil', 'GuruNon::deleteBerkas');

$routes->get('/kurikulum', 'Kurikulum::index');
$routes->get('/refkurikulum', 'Kurikulum::get');
$routes->post('/kurikulum', 'Kurikulum::Insert');
$routes->PUT('/kurikulum', 'Kurikulum::Update');

// Tarik Data
$routes->get('/wakasekold', 'TarikData::wakasek');
$routes->post('/wakasekold', 'TarikData::TarikWakasek');
$routes->get('/kelaslulus', 'TarikData::Lulus');
$routes->post('/tarikkelas', 'TarikData::Kelas');

// Surat
$routes->get('/surat-masuk', 'Surat::SuratMasuk');
$routes->get('/surat-keluar', 'Surat::SuratKeluar');
$routes->get('/getsurat-masuk', 'Surat::getSuratMasuk');
$routes->get('/getsurat-keluar', 'Surat::getSuratKeluar');

$routes->post('/surat', 'Surat::Insert');
$routes->post('/upload-surat', 'Surat::Upload');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
