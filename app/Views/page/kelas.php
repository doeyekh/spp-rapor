<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4><?= $title; ?></h4>
    </div>
    <div class="section-body">
        <div class="card">
            
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#exampleModal">
                    Tambah
                </button>
                <?php if(oldtahunajar() != NULL) :?>
                    <button type="button" class="btn btn-success btn-tarik ml-2">
                        Salin Kelas
                    </button>
                <?php endif; ?>
                <?php if(tahunajar()->smt == 'Ganjil') :?>
                    <button type="button" class="btn btn-warning btn-lulus ml-2">
                        Luluskan Tingkat Akhir
                    </button>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="jk" class="col-sm-2 col-form-label">Sekolah / Lembaga</label>
                    <div class="col-sm-10">
                        <select name="sekolah" id="sekolah" class="form-control form-control-sm select2">
                            <?php 
                            if(in_array('Administrator',userLevel())){
                                ?>
                                <option value="">-Pilih Sekolah-</option>
                            <?php } foreach($sekolah as $lembaga): ?>
                                    <option value="<?= $lembaga->id_lembaga; ?>" ><?= $lembaga->nama_sekolah; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tingkat</th>
                                <th>Nama</th>
                                <th>Wali Kelas</th>
                                <th>Kurikulum</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalSiswa"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <table class="table table-hover table-striped table-sm" id="tabelAnggota">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIPD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">
                                    <button class="btn btn-danger btn-sm removeAnggota">Keluarkan</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-5 col-sm-12">
                    
                        <h4>Tambah Siswa Ke Rombel</h4>
                                <table class="table table-striped table-sm table-hover " id="tabelRombel">
                                    <thead>
                                        <tr>
                                            <th width='5%'> 
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div> 
                                            </th>
                                            <th>Nama</th>
                                            <th width='15%'>NISN</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                <button class="btn btn-primary btn-sm btnAnggota">Simpan</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                        
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-close" >Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formuser">
        <div class="modal-body">
            <div class="form-group row nm">
                <label for="lembaga" class="col-sm-2 col-form-label">Lembaga</label>
                <div class="col-sm-10">
                    <select name="lembaga" class="form-control lembaga" id="lembaga">
                        <option value="">--Pilih Lembaga--</option>
                        <?php foreach($sekolah as $lembaga): ?>
                                    <option data="<?= $lembaga->id_jenjang; ?>" value="<?= $lembaga->id_lembaga; ?>" ><?= $lembaga->nama_sekolah; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="errorlembaga invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row nm">
                <label for="tingkat" class="col-sm-2 col-form-label">Tingkat</label>
                <div class="col-sm-10">
                    <select name="tingkat" class="form-control" id="tingkat">
                        
                    </select>
                    <div class="errortingkat invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row nm">
                <label for="kurikulum" class="col-sm-2 col-form-label">Kurikulum</label>
                <div class="col-sm-10">
                    <select name="kurikulum" class="form-control" id="kurikulum" >
                        
                    </select>
                    <div class="errorkurikulum invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama"  id="nama"  placeholder="Nama Kelas...">
                    <input type="hidden" class="form-control" name="id"  id="id">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="wakel" class="col-sm-2 col-form-label">Wali Kelas</label>
                <div class="col-sm-10">
                    <select name="wakel" id="wakel" class="form-control select2">
                        <?php foreach($guru as $row) : ?>
                            <option value="<?= $row->id_guru; ?>"><?= $row->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
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
<?php if(oldtahunajar() != NULL) :?>
    <div class="modal fade" id="tarikModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <form id="formtarik">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="oldkelas" class="col-sm-2 col-form-label">Pilih Kelas</label>
                    <div class="col-sm-10">
                        <select name="oldkelas" id="oldkelas" class="form-control">
                            <?php  foreach($kelas as $lembaga): ?>
                                <option value="<?= $lembaga->id_kelas; ?>" ><?= $lembaga->nama_tingkat; ?> | <?= $lembaga->nama_kelas; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="erroroldkelas invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lmg" class="col-sm-2 col-form-label">Kelas Tujuan</label>
                    <div class="col-sm-10">
                        <select name="oldtingkat" id="oldtingkat" class="form-control">
                            <?php  foreach($jenjang as $lembaga): ?>
                                <option value="<?= $lembaga->id_jenjangkelas; ?>" ><?= $lembaga->nama_tingkat; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="erroroldtingkat invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="oldnama" class="col-sm-2 col-form-label">Nama Kelas</label>
                    <div class="col-sm-10">
                        <input type="text" name="oldnama" id="oldnama" class="form-control">
                        <div class="erroroldnama invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                <label for="oldwakel" class="col-sm-2 col-form-label">Wali Kelas</label>
                <div class="col-sm-10">
                    <select name="oldwakel" id="oldwakel" class="form-control select2">
                        <?php foreach($guru as $row) : ?>
                            <option value="<?= $row->id_guru; ?>"><?= $row->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-simpan">Salin Data</button>
            </div>
        </form>
        </div>
    </div>
    </div>
<?php endif; ?>
<?php if(tahunajar()->smt == 'Ganjil') : ?>
    <div class="modal fade" id="lulusModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <form id="formlulus">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="lmg" class="col-sm-2 col-form-label">Pilih Kelas</label>
                    <div class="col-sm-10">
                        <select name="lmg" id="lmg1" class="form-control">
                            <?php if(in_array('Administrator',userLevel())){ ?>
                                <option value="">-Pilih Sekolah-</option>
                            <?php } foreach($kelas as $dkelas): ?>
                                <option value="<?= $dkelas->id_lembaga; ?>" ><?= $dkelas->nama_kelas; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="errorlmg invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-save">Salin Data</button>
            </div>
        </form>
        </div>
    </div>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script src="assets/js/page/components-table.js"></script>
<script>
$(document).ready(function(){
    var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url : '/kelasget',
                data: function (d) {
                d.lembaga = $('#sekolah').val();
                }
            },
        info: false,
        paging : false,
        ordering: false,
        searching: false,
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data :'nama_tingkat',sClass : 'text-center'},
            {data :'nama_kelas'},
            {data :'nama'},
            {data :'nama_kurikulum'},
            {data :'id_kelas',
                mRender: function (data, type, full) {
                    html ='<button class="btn btn-sm btn-info btn-icon ml-1 btnEdit" id="'+full['id_kelas']+'" data-toggle="tooltip" data-placement="left" title="Edit Data"><i class="fas fa-edit"></i></button>';
                    html +='<button class="btn btn-sm btn-warning btn-icon ml-1 btnbelajar" id="'+full['id_kelas']+'" data-toggle="tooltip" data-placement="left" title="Setting Pembelajaran"><i class="fas fa-file"></i></button>'
                    html +='<button class="btn btn-sm btn-success btn-icon ml-1 btnsiswa" data-nama="'+full['nama_kelas']+'" lembaga="'+full['id_lembaga']+'" id="'+full['id_kelas']+'" data-toggle="tooltip" data-placement="left" title="Anggota Rombel"><i class="fas fa-users"></i></button>'
                return html;
                },
            },
        ]
    });
    $('#sekolah').change(function(event) {
        tabel.ajax.reload();
    });
    $(document).on('click','.btn-close',function(){
        $('#modalSiswa').modal('hide');
        tabel.ajax.reload();
        tabelrombel.destroy()
    })
    $(document).on('click','.btn-add',function(){
        $('.modal-title').html('Tambah Data Kelas');
        $('#formuser')[0].reset()
        $('.btn-save').html('Simpan')
        $('.nm').show();
    })
    
    $(document).on('click','.btnsiswa',function(){
        $('#modalSiswa').modal('show');
        $('.modal-title').html('Anggota Rombel');
        var id = $(this).attr('id');
        var nama = $(this).attr('data-nama');
        var lembaga = $(this).attr('lembaga');
        $('.btnAnggota').attr('data-id',id);
        $('.removeAnggota').attr('data-id',id);
        $('.btnAnggota').attr('data-nama',nama);
        $('.btnAnggota').attr('data-lembaga',lembaga);
        var tabelrombel = $('#tabelRombel').DataTable({
            processing: true,
            serverSide: true,
            "destroy": true,
            paging : false,
            ajax: '/getrombelnon/'+lembaga,
            order :[],
            columns: [
                { 
                data: 'id_siswa', sClass : 'text-right',
                orderable: false,
                mRender : function(data,type,full){
                datacek = '<div class="custom-checkbox custom-control">'
                datacek += '<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input chekboxmap"  value="'+data+'" name="idsiswa" id="checkbox-'+full['nomor']+'">'
                datacek += '<label for="checkbox-'+full['nomor']+'"  class="custom-control-label">&nbsp;</label> </div>'       
                    return datacek
                    },
                },
                {data : 'nama_siswa'},
                {data : 'nisn'},
            ]
        })
        var tabelanggota = $('#tabelAnggota').DataTable({
            processing: true,
            serverSide: true,
            "destroy": true,
            paging : false,
            ajax: '/getrombel/'+id+'/'+lembaga,
            order :[],
            columns: [
                { 
                data: 'id_siswa', sClass : 'text-right',
                orderable: false,
                mRender : function(data,type,full){
                datacek = '<div class="custom-checkbox custom-control">'
                datacek += '<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input chekbox"  value="'+data+'" name="idsiswa" id="check-'+full['nomor']+'">'
                datacek += '<label for="check-'+full['nomor']+'"  class="custom-control-label">&nbsp;</label> </div>'       
                    return datacek
                    },
                },
                {data : 'nama_siswa'},
                {data : 'nipd'},
                {data : 'nisn'},
            ]
        });
    })
    $(document).on('click','.btnAnggota',function(){
        var chekboxmap = $('.chekboxmap:checked');
        var kelas = $(this).attr('data-id');
        var nama = $(this).attr('data-nama')
        var lembaga = $(this).attr('data-lembaga')
        if(chekboxmap.length > 0 )
            {
                var checkbox_value = [];
                    $(chekboxmap).each(function(){
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        method : 'post',
                        url : '/rombel',
                        data :{
                            checkbox_value:checkbox_value,
                            kelas:kelas,
                            nama : nama,
                            lembaga : lembaga,
                            _method : 'POST'
                        },
                        success: function(respon){
                                iziToast.success({
                                    title: 'Berhasil',
                                    message: 'Siswa Berhasil Ditambahkan',
                                    position: 'topRight',
                                    timeout: 5000,
                                });
                        $('#modalSiswa').modal('hide');
                        },
                    })
            }else{
                alert('Tidak Ada Siswa Yang DIpilih')
            }
    })

    $(document).on('click','.removeAnggota',function(){
        var chekbox = $('.chekbox:checked');
        var kelas = $(this).attr('data-id');
        if(chekbox.length > 0 )
            {
                var checkbox_value = [];
                    $(chekbox).each(function(){
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        method : 'post',
                        url : '/rombel',
                        data :{
                            checkbox_value:checkbox_value,
                            kelas:kelas,
                            _method : 'PUT'
                        },
                        success: function(respon){
                                iziToast.success({
                                title: 'Berhasil',
                                message: 'Siswa Berhasil Ditambahkan',
                                position: 'topRight',
                                timeout: 5000,
                            });
                        $('#modalSiswa').modal('hide');
                        },
                    })
            }else{
                iziToast.error({
                    title: 'Warning',
                    message: 'Tidak Ada Siswa Yang Dipilih',
                    position: 'topRight',
                    timeout: 5000,
                });
            }
    })

    $(document).on('click','.btnEdit',function(){
        var id = $(this).attr('id');
        $.ajax({
            url : '/kelas',
            method : 'post',
            data : {id:id,_method:'PUT'},
            dataType : 'json',
            success : function(e){
                $('.nm').hide();
                $('#lembaga').val(e.id_lembaga);
                $('#tingkat').val(e.id_jenjangkelas);
                $('#nama').val(e.nama_kelas);
                $('#kurikulum').val(e.id_kurikulum);
                $('#id').val(e.id_kelas);
                $('.modal-title').html('Edit Data Kelas');
                $('.btn-save').html('Edit')
                $('#exampleModal').modal('show');
            }
        })
    })

    $(document).on('submit','#formuser',function(e){
        e.preventDefault();
        $.ajax({
            url : '/kelas',
            method : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(e){
                console.log(e);
                if(e.error){
                    if(e.error.lembaga){
                        $('#lembaga').addClass('is-invalid');
                        $('.errorlembaga').html(e.error.lembaga);
                    }else{
                        $('#lembaga').removeClass('is-invalid');
                        $('.errorlembaga').html();
                    }
                    if(e.error.tingkat){
                        $('#tingkat').addClass('is-invalid');
                        $('.errortingkat').html(e.error.tingkat);
                    }else{
                        $('#tingkat').removeClass('is-invalid');
                        $('.errortingkat').html();
                    }

                    if(e.error.kurikulum){
                        $('#kurikulum').addClass('is-invalid');
                        $('.errorkurikulum').html(e.error.kurikulum);
                    }else{
                        $('#kurikulum').removeClass('is-invalid');
                        $('.errorkurikulum').html();
                    }
                    if(e.error.nama){
                        $('#nama').addClass('is-invalid');
                        $('.errornama').html(e.error.nama);
                    }else{
                        $('#nama').removeClass('is-invalid');
                        $('.errornama').html();
                    }
                }else{
                    iziToast.success({
                        title: 'Berhasil',
                        message: e.sukses,
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#exampleModal').modal('hide');
                    $('#formuser')[0].reset();
                    tabel.ajax.reload();
                }
            }
        })
    })

    $(document).on('click','.btn-tarik',function(){
        $('#tarikModal').modal('show')
        $('.modal-title').html('Salin Data')
    })

    $(document).on('click','.btn-lulus',function(){
        $('#lulusModal').modal('show')
        $('.modal-title').html('Luluskan Siswa Tingkat Akhir');
        $('.btn-save').html('Proses');
    })

    $(document).on('change','#lembaga',function(){
        var data = $("#lembaga").find(':selected').attr('data');
        $.ajax({
            url : '/getJenjang',
            data : {data:data,_method:'PUT'},
            method:'post',
            success:function(e){
                $("#tingkat").html(e);
            }
        })
    });

    $(document).on('change','.lembaga',function(){
        var data = $("#lembaga").find(':selected').attr('data');
        $.ajax({
            url : '/getKurikulum',
            data : {data:data,_method:'PUT'},
            method:'post',
            success:function(e){
                $("#kurikulum").html(e);
            }
        })
    })

    $(document).on('submit','#formtarik',function(e){
        e.preventDefault();
        $.ajax({
            url : '/tarikkelas',
            method : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success : function(respon){
                console.log(respon)
                if(respon.error){
                    if(respon.error.kelas){
                        $('#oldkelas').addClass('is-invalid')
                        $('.erroroldkelas').html(respon.error.kelas)
                    }else{
                        $('#oldkelas').removeClass('is-invalid')
                        $('.erroroldkelas').html(``) 
                    }
                    if(respon.error.tingkat){
                        $('#oldtingkat').addClass('is-invalid')
                        $('.erroroldtingkat').html(respon.error.tingkat)
                    }else{
                        $('#oldtingkat').removeClass('is-invalid')
                        $('.erroroldtingkat').html(``) 
                    }
                    if(respon.error.nama){
                        $('#oldnama').addClass('is-invalid')
                        $('.erroroldnama').html(respon.error.nama)
                    }else{
                        $('#oldnama').removeClass('is-invalid')
                        $('.erroroldnama').html(``) 
                    }
                    if(respon.error.wakel){
                        $('#oldwakel').addClass('is-invalid')
                        $('.erroroldwakel').html(respon.error.wakel)
                    }else{
                        $('#oldwakel').removeClass('is-invalid')
                        $('.erroroldwakel').html(``) 
                    }
                }
                if(respon.sukses){
                    $('#tarikModal').modal('hide');
                    $('#formtarik')[0].reset();
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data Kelas Berhasil Disalin',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    tabel.ajax.reload();
                }
            }
        })
    })
})
</script>
<?= $this->endSection(); ?>