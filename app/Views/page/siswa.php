<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4>Daftar Siswa</h4>
    </div>
    <div class="section-body">
        <div class="card">
            <?php 
            if(in_array('Operator',userLevel())):
            ?>
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#exampleModal">
                    Tambah
                </button>
                <button type="button" class="btn btn-warning btn-tarik ml-2" data-toggle="modal" data-target="#tarikModal">
                    Tarik Data
                </button>
                <button type="button" class="btn btn-info btn-status ml-2">
                    Update Status
                </button>
                
                <div class="dropdown d-inline ml-2">
                      <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Import
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item has-icon" id="modal" href="javascript:void(0)"><i class="far fa-heart"></i> Import</a>
                        <a class="dropdown-item has-icon" href="<?= base_url(); ?>template/template_siswa.xlsx"><i class="far fa-file"></i> Template Excel</a>
                      </div>
                      
                </div>
            </div>
            <?php 
        endif; 
        $jab = count($lembaga);
        ?>
            <div class="card-body">
                
                    <div class="form-group row">
                    <label for="registrasi" class="col-sm-2 col-form-label">Pilih Sekolah</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <select name="lembaga" class="form-control" id="sch">
                                        <?php 
                                            if(in_array('Administrator',userLevel())){
                                             $id = [];
                                            }elseif(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel())){
                                                $id = ['id_jenjang'=>jenjang()->id_jenjang];
                                            } elseif(in_array('Koordinator',userLevel())){
                                                $id = ['id_lembaga'=>jenjang()->id_lembaga];
                                            }
                                        ?>
                                        <?php if(in_array('Administrator',userLevel())) :  ?>
                                            <option value="">-Semua-</option>
                                        <?php endif; ?>
                                        <?php foreach(getLembaga($id)->getResultArray() as $row): ?>
                                            <option value="<?= $row['id_lembaga']; ?>"><?= $row['nama_sekolah']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                    </div>
                    
                    
                    <table class="table table-hover table-sm" id="tableData">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>L/P</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Kelas</th>
                                <th>Dapodik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</section>
<?php 
// if(userlevel()->jabatan=='Operator'): 
?>
<div class="modal fade" id="alumniModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Form Mutasi Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formalumni" method="post">
        <div class="modal-body">
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama Siswa</label>
                <div class="col-sm-10">
                    <input type="text" name="" readonly id="namasiswa" class="form-control">
                    <input type="hidden" name="idregistrasisiswa" id="idregistrasisiswa" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Sekolah</label>
                <div class="col-sm-10">
                    <input type="text" readonly id="lembaga" class="form-control">
                    <input type="hidden" name="idlembaga" id="idlembaga" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                <div class="col-sm-10">
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">-Jenis Mutasi-</option>
                        <option value="Mutasi">Mutasi / Pindah</option>
                        <option value="Dikeluarkan">Dikeluarkan</option>
                        <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                        <option value="Meninggal Dunia">Meninggal Dunia</option>
                    </select>
                </div>
            </div>
            <div class="form-group row sekolahtujuan">
                <label for="smt" class="col-sm-2 col-form-label">Sekolah Tujuan</label>
                <div class="col-sm-10">
                    <input type="text" name="tujuan" id="tujuan" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Alasan</label>
                <div class="col-sm-10">
                    <textarea name="alasan" id="alasan" class="form-control" cols="50" rows="5"></textarea>
                </div>
                <input type="hidden" name="id" id="id" class="form-control">
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btnsavealumni">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="nipdModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Edit NIPD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formnipd" method="post">
        <div class="modal-body">
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama Siswa</label>
                <div class="col-sm-10">
                    <input type="text" name="" readonly id="namanipd" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">No NIPD</label>
                <div class="col-sm-10">
                    <input type="number" name="nipd" id="nipd" class="form-control">
                    <input type="hidden" name="idsiswa" id="idsiswa" class="form-control">
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <?php if(in_array('Operator',userLevel())) : ?>
            <button type="submit" class="btn btn-primary btnsavenipd">Simpan</button>
            <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="importModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formImport" method="post" name="formimport" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
        <div class="modal-body">
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Pilih File</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="excel"  id="excel">
                    <div class="errorexcel invalid-feedback"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="lmg" class="col-sm-2 col-form-label">Pilih Lembaga</label>
                <div class="col-sm-10">
                    <select name="lmg" id="lmg" class="form-control select2">
                        <?php if(in_array('Administrator',userLevel())) :  ?>
                            <option value="">-Semua-</option>
                        <?php endif; ?>
                        <?php foreach(getLembaga($id)->getResultArray() as $row): ?>
                            <option value="<?= $row['id_lembaga']; ?>"><?= $row['nama_sekolah']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="errorlmg invalid-feedback"></div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-import">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="tarikModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="tarikModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TarikModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
    <form id="formTarik" method="post" name="formtarik" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
        <div class="modal-body">
            
            <div class="form-group row">
                <label for="lmg" class="col-sm-2 col-form-label">Pilih Lembaga</label>
                <div class="col-sm-10">
                    <select name="lmg" id="lmg1" class="form-control">
                        <?php if(in_array('Administrator',userLevel())) :  ?>
                            <option value="">-Semua-</option>
                        <?php endif; ?>
                        <?php foreach(getLembaga($id)->getResultArray() as $row): ?>
                            <option value="<?= $row['id_lembaga']; ?>"><?= $row['nama_sekolah']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="errorlmg invalid-feedback"></div>
                </div>
            </div>
            <table class="table" id="tableTarik">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>L/P</th>
                    </tr>
                </thead>
            </table>

            
        </div>
        <div class="modal-footer">  
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btntarik">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formuser" autocomplete="off">
        <div class="modal-body">
            <div class="form-group row">
                <label for="jk" class="col-sm-2 col-form-label">Sekolah / Lembaga</label>
                <div class="col-sm-10">
                    <select name="lembaga" id="lembaga" class="form-control form-control-sm select2">
                        <?php foreach($sekolah as $lembaga): ?>
                                <option value="<?= $lembaga->id_lembaga; ?>" ><?= $lembaga->nama_sekolah; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-5">
                    <input type="number" class="form-control"  name="nik" id="nik" placeholder="No NIK.." >
                    <div class="errornik invalid-feedback">
                        
                    </div>
                </div>
                <div class="col-sm-5">
                    <input type="number" class="form-control"  name="nisn" id="nisn" placeholder="No NISN" >
                    <div class="errornisn invalid-feedback">
                        
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama"  id="nama"  placeholder="Nama Lengkap...">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Tmp, Tgl Lahir</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tmp"  id="tmp" placeholder="Tempat Lahir..." >
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="date" class="form-control daterange-cus" name="tgl">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">No Hp</label>
                <div class="col-sm-10">
                 <input type="number" class="form-control" name="nohp"  id="nohp" placeholder="No Hp..." >
                   
                </div>
            </div>
            
            <div class="form-group row">
                <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select name="jk" id="jk" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="jayahk" class="col-sm-2 col-form-label">Orang Tua</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="ayah" name="ayah" placeholder="Nama Ayah.">
                </div>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="ibu" name="ibu" placeholder="Nama Ibu.">
                </div>
            </div>
            <div class="form-group row">
                <label for="ayah" class="col-sm-2 col-form-label">Pekerjaan Orang Tua</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="kerjaayah" name="kerjaayah" placeholder="Pekerjaan Ayah.">
                </div>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="kerjaibu" name="kerjaibu" placeholder="Pekerjaan Ibu.">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-save">Save changes</button>
        </div>
      </form>
    </div>
  </div>
  
</div>
<?php 
// endif 
?>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script src="assets/js/page/components-table.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','#modal',function(){
            $('#importModal').modal('show');
            $('.btn-import').html(`Import`);
        })
        
        var tabel = $('#tableData').DataTable({
            
            processing: true,
            serverSide: true,
            ajax: {
                    url : '/siswa',
                    data: function (d) {
                        d.lembaga = $('#sch').val();
                }
            },
            order :[],
            columns: [
                {data: 'nomor', orderable: false,
                    mRender: function(data,type,full){
                        html = '<div class="custom-checkbox custom-control">'
                        html +=   '<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input chekboxmap" value="'+full['id_siswa']+'" id="checkbox-'+data+'">'
                        html +=   '<label for="checkbox-'+data+'" class="custom-control-label">&nbsp;</label>'
                        html +=   '</div>'
                        return html
                    }
                },
                {data : 'nisn',sClass : 'text-center'},
                {data : 'nama_siswa',sClass : 'text-center'},
                {data: 'jenis_kelamin', sClass: "text-center",
                    mRender: function (data, type, full) {
                        if(full['jenis_kelamin']=='L')
                        {
                            html ='Laki-Laki'
                        }else{
                            html ='Perempuan'
                            
                        }
                        return html;
                    },
                },
                {data : 'tempat_lahir',sClass : 'text-center',
                mRender : function(data,type,full)
                {
                    return data+', '+full['tgl_lahir'];
                }
            },
                {data : 'kelas',sClass : 'text-center'},
                {
                    data : 'status',sClass : 'text-center',
                    mRender : function(data,type,full){
                    if(data==0){
                        return '<span class="btn btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i></span>'
                    }else{
                        return '<span class="btn btn-sm btn-icon btn-success"><i class="far fa-check-circle"></i></span>'
                    }
                }
                },
                
                {
                    data : 'id_siswa',sClass : 'text-center',
                    mRender : function(data,type,full)
                    {
                        html=  '<button class="btn btn-sm btn-success btn-icon ml-1 btnnipd"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit NIPD"><i class="fas fa-file"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1 btnsiswa"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Siswa"><i class="fas fa-user-edit"></i></button>'
                        html +='<button class="btn btn-sm btn-danger btn-icon ml-1 btnmutasi"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Keluarkan"><i class="fas fa-power-off"></i></button>'
                        return html
                    }
                },
            ]
        });
        $('#sch').change(function(event) {
            tabel.ajax.reload();
        });
        $(document).on('click','.btn-status',function(){
            var chekboxmap = $('.chekboxmap:checked');
            if(chekboxmap.length > 0 )
            {
                var checkbox_value = [];
                    $(chekboxmap).each(function(){
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        method : 'post',
                        url : '/statusdapo',
                        data :{
                            checkbox_value:checkbox_value,
                            _method : 'POST'
                        },
                        success: function(respon){
                            console.log(respon)
                                iziToast.success({
                                    title: 'Berhasil',
                                    message: respon +' Siswa Berhasil Diperbaharui',
                                    position: 'topRight',
                                    timeout: 5000,
                                });
                                tabel.ajax.reload()
                        
                        },
                    })
            }else{
                alert('Harap Pilih Siswa Terlebih Dahulu');
            }
        })
        $(document).on('click','.btntarik',function(e){
            e.preventDefault()
            var chekbox = $('.chekbox:checked');
            var lmg = $('#lmg1').val();
            if(lmg !=''){
                if(chekbox.length > 0 )
            {
                var checkbox_value = [];
                    $(chekbox).each(function(){
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        method : 'post',
                        url : '/tarikregister',
                        dataType : 'json',
                        data :{
                            checkbox_value:checkbox_value,
                            lmg : lmg,
                            _method : 'POST'
                        },
                        beforeSend : function(e){
                            $('.btntarik').prop('disabled','disabled');
                            $('btntarik').html(`<i class="fa fa-spin fa-spinner"></i>`);
                        },
                        complete : function(e){
                            $('.btntarik').removeAttr('disabled');
                            $('.btntarik').html(`Tarik Data`);
                        },
                        success: function(respon){
                            iziToast.success({
                                title: 'Berhasil',
                                message: respon.sukses.Berhasil +' Siswa Berhasil Ditarik ' + respon.sukses.gagal +' Gagal Berhasil Ditarik ',
                                position: 'topRight',
                                timeout: 5000,
                            });
                            tabel.ajax.reload()
                            $('#tarikModal').modal('hide')
                        },
                    })
                }else{
                    iziToast.error({
                        title: 'Error',
                        message: 'Silahkan Pilih Siswa Terlebih Dahulu',
                        position: 'topRight',
                        timeout: 5000,
                    });
                }
            }else{
                iziToast.error({
                        title: 'Error',
                        message: 'Silahkan Pilih Lembaga Terlebih Dahulu',
                        position: 'topRight',
                        timeout: 5000,
                    });
            }
            
        })

        $(document).on('click','.btn-tarik',function(){
            $('#TarikModalLabel').html('Tarik Data Siswa / Santri')
            $('.btntarik').html('Tarik Data')

            var tabeltarik = $('#tableTarik').DataTable({
            lengthMenu: [ 5],
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '/siswa-tarik',
            order :[],
            columns: [
                {
                    data: 'nomor', orderable: false,
                    mRender: function(data,type,full){
                       html = '<div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup" class="custom-control-input chekbox" value="'+full['id_siswa']+'" name="idsiswa" id="check-'+data+'"><label for="check-'+data+'" class="custom-control-label">&nbsp;</label> </div>'
                        
                        return html
                    }
                },
                {data : 'nisn',sClass : 'text-center'},
                {data : 'nama_siswa',sClass : 'text-center'},
                {data: 'jenis_kelamin', sClass: "text-center",
                    mRender: function (data, type, full) {
                        if(full['jenis_kelamin']=='L')
                        {
                            html ='Laki-Laki'
                        }else{
                            html ='Perempuan'
                            
                        }
                        return html;
                    },
                },
                
            ]
        });
        })
        $(document).on('click','.btnsiswa',function(){
            var id = $(this).attr('id');
            location.assign('siswa/'+id);
        })
        
        $(document).on('click','.btnnipd',function(){
            var id = $(this).attr('id');
            $.ajax({
                url : base_url + '/siswa-ak',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(e){
                    console.log(e);
                    $('#namanipd').val(e.nama_siswa);
                    $('#nipd').val(e.nipd);
                    $('#idsiswa').val(e.id_siswa);
                    $('#nipdModal').modal('show');
                }
            })
        });

        $(document).on('click','.btnmutasi',function(){
            var id = $(this).attr('id');
            $.ajax({
                url : base_url + '/siswa-ak',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(e){
                    console.log(e);
                    $('.sekolahtujuan').hide()
                    $('#namasiswa').val(e.nama_siswa);
                    $('#id').val(e.id_siswa);
                    $('#idlembaga').val(e.id_lembaga);
                    $('#lembaga').val(e.nama_sekolah);
                    $('#idregistrasisiswa').val(e.id_registrasi);
                    $('#alumniModal').modal('show');
                }
            })
        });
        $(document).on('change','#jenis',function(){
            $(this).val() ==='Mutasi' ? $('.sekolahtujuan').show() : $('.sekolahtujuan').hide()
        })
        $(document).on('submit','#formalumni',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url + '/alumni',
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                beforeSend : function(data){
                    $('.btnsavealumni').prop('disabled','disabled');
                    $('.btnsavealumni').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(data){
                    $('.btnsavealumni').removeAttr('disabled');
                    $('.btnsavealumni').html(`Simpan`);
                },
                success : function(data)
                {
                    console.log(data)
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Siswa Berhasil Dinon Aktifkan',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#alumniModal').modal('hide');
                    tabel.ajax.reload(); 
                }
            })
        });
        $(document).on('submit','#formnipd',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url + '/register',
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                beforeSend : function(data){
                    $('.btnsavenipd').prop('disabled','disabled');
                    $('.btnsavenipd').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(data){
                    $('.btnsavenipd').removeAttr('disabled');
                    $('.btnsavenipd').html(`Simpan`);
                },
                success : function(data)
                {
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'NIPD Berhasil Diperbaharui',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#nipdModal').modal('hide');
                    tabel.ajax.reload(); 
                }
            })
        });
        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
                url: '/siswa',
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                beforeSend : function(e){
                    $('.btn-save').prop('disabled','disabled');
                    $('.btn-save').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(e){
                    $('.btn-save').removeAttr('disabled');
                    $('.btn-save').html(`Tambah`);
                },
                success : function(data)
                {
                    console.log(data);
                    if(data.error)
                    {
                        if(data.error.nik)
                        {
                            $('#nik').addClass('is-invalid');
                            $('.errornik').html(data.error.nik);
                        }else{
                            $('#nik').removeClass('is-invalid');
                            $('.errornik').html('');
                        }

                        if(data.error.nisn)
                        {
                            $('#nisn').addClass('is-invalid');
                            $('.errornisn').html(data.error.nik);
                        }else{
                            $('#nisn').removeClass('is-invalid');
                            $('.errornisn').html('');
                        }
                        if(data.error.nama)
                        {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(data.error.nama);
                        }else{
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html('');
                        }

                        
                    }else{
                        iziToast.success({
                        title: 'Berhasil',
                        message: data.sukses,
                        position: 'topRight',
                        timeout: 5000,
                        });
                        $('#formuser')[0].reset();
                        $('#exampleModal').modal('hide');
                        tabel.ajax.reload();
                    }
                }
            })
        })
        $(document).on('submit','#formImport',function(e){
            e.preventDefault();
            $.ajax({
                url: base_url +'/siswa',
                method : 'post',
                data : new FormData(this),
                enctype : 'multipart/form-data',
                processData: false,
                contentType: false,
                cache : false,
                dataType : 'json',
                beforeSend : function(e){
                    $('.btn-import').prop('disabled','disabled');
                    $('btn-import').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(e){
                    $('.btn-import').removeAttr('disabled');
                    $('.btn-import').html(`Import`);
                },
                success : function(data)
                {
                    console.log(data);
                    if(data.error)
                    {
                        if(data.error.excel)
                        {
                            $('#excel').addClass('is-invalid');
                            $('.errorexcel').html(data.error.excel);
                        }else{
                            $('#excel').removeClass('is-invalid');
                            $('.errorexcel').html('');
                        }

                        if(data.error.lmg)
                        {
                            $('#lmg').addClass('is-invalid');
                            $('.errorlmg').html(data.error.lmg);
                        }else{
                            $('#lmg').removeClass('is-invalid');
                            $('.errorlmg').html('');
                        }

                        
                    }else{
                        iziToast.success({
                        title: 'Import Berhasil',
                        message: data.sukses.Berhasil +' Data Berhasil Ditambahkan ' + data.sukses.gagal +' Data Gagal Ditambahkan',
                        position: 'topRight',
                        timeout: 5000,
                        });
                        $('#importModal').modal('hide');
                        tabel.ajax.reload();
                    }
                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>