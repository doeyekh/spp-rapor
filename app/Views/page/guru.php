<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4>Daftar Guru</h4>
    </div>
    <div class="section-body">
        <div class="card">
            <?php 
            if(in_array('Operator',userLevel()) || in_array('Administrator',userLevel())): 
            ?>
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#exampleModal">
                    Tambah
                </button>
                <button type="button" class="btn btn-success btn-icon btn-import ml-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-upload"></i>
                    Import
                </button>
            </div>
            <?php 
        endif; 
        ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <?php if(in_array('Operator',userLevel())): ?>
                <a href="guru/download" class="btn btn-sm btn-primary btn-download"><i class="fas fa-download"></i> Export</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php 
if(in_array('Operator',userLevel()) || in_array('Administrator',userLevel())):
?>

    <div class="modal fade" id="importModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formImport" method="post" name="formimport" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Pilih File</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="excel"  id="excel">
                    <div class="errorfile invalid-feedback">
                          
                    </div>
                </div>
            </div>
            klik <a href="<?= base_url(); ?>template/guru.xlsx">disini</a> Untuk Mendownload Format
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-import">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control"  name="nik" id="nik" placeholder="No NIK.." >
                    <div class="errornik invalid-feedback">
                          
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
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email"  id="email" placeholder="E-Mail..." >
                    <div class="erroremail invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="nohp" class="col-sm-2 col-form-label">No HP</label>
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
endif 
?>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/guruget',
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data: 'foto', sClass: "text-center",
                mRender: function (data, type, full) {
                    html = "<div class='avatar me-2'><img src='assets/img/avatar/"+full['foto']+"' alt='Avatar' class='rounded circle'></div>";
                return html;
                },
            },
            {data : 'nama',sClass : 'text-left'},
            {data : 'tempat_lahir',sClass : 'text-left',
                mRender : function(data,type,full)
                {
                    return full['tempat_lahir']+', '+full['tgl_lahir'];
                }
            },
            
            {data : 'email',sClass : 'text-left'},
            {data: 'is_active', sClass: "text-center",
                mRender: function (data, type, full) {
                    if(full['action'] !='operator'){
                        html ='<button class="btn btn-sm btn-info btn-icon ml-1 btnDetail" id="'+full['id_guru']+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-user-edit"></i></button>'
                    }else{

                    
                    html ='<button class="btn btn-sm btn-primary btn-icon btnReset" id="'+full['id_guru']+'" data-toggle="tooltip" data-placement="left" title="Reset Password"><i class="fas fa-undo-alt"></i></button>'
                    html +='<button class="btn btn-sm btn-danger btn-icon ml-1 btnPower" id="'+full['id_guru']+'" data-toggle="tooltip" data-placement="left" title="Non Aktifkan"><i class="fas fa-power-off"></i></button>'
                    html +='<button class="btn btn-sm btn-info btn-icon ml-1 btnDetail" id="'+full['id_guru']+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-user-edit"></i></button>'
                    }
                    return html;
                },
            }
        ]
    });
    $(document).on('click','.btnReset',function(){
        var id = $(this).attr('id');
        swal({
            title: 'Are you sure ?',
            text: 'Password Akan di resset Ke Password Default',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url :'/guru',
                        method : 'post',
                        data : {id:id,_method:'PUT'},
                        success : function(data){
                            swal('Silahkan Login dengan Password : 12345', {
                                icon: 'success',
                            });
                            tabel.ajax.reload();
                        }
                    })
                }else{
                    swal('Password Belum diResset');
                    }
                });
    });
    
    $(document).on('click','.btnPower',function(){
        var id = $(this).attr('id');
        swal({
            title: 'Are you sure ?',
            text: 'Password Akan di resset Ke Password Default',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url :'/guru',
                        method : 'post',
                        data : {id:id,_method:'DELETE'},
                        success : function(data){
                            swal('Guru Telah Dinon Aktifkan', {
                                icon: 'success',
                            });
                            tabel.ajax.reload();
                        }
                    })
                }else{
                    swal('Password Belum diResset');
                    }
                });
    });

    $(document).on('submit','#formImport',function(e){
        e.preventDefault();
        $.ajax({
            url : '/guru/import',
            method : 'post',
            data : new FormData(this),
            enctype : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache : false,
            dataType : 'json',
            beforeSend : function(e){
                $('.btn-import').prop('disabled','disabled');
                $('.btn-import').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete : function(e){
                $('.btn-import').removeAttr('disabled');
                $('.btn-import').html(`Import`);
            },
            success: function(respon){
                if(respon.error){
                    $('#excel').addClass('is-invalid');
                    $('.errorfile').html(respon.error.excel);
                }else{
                    $('#excel').removeClass('is-invalid');
                    $('.errorfile').html('');
                }
                if(respon.sukses){
                    iziToast.success({
                        title: 'Import Berhasil',
                        message: respon.sukses.Berhasil +' Data Berhasil Ditambahkan ' + respon.sukses.gagal +' Data Gagal Ditambahkan',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#importModal').modal('hide');
                    tabel.ajax.reload();
                }
            },
            error:function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
            }
        })
    })

        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
            url : '/guru',
            method : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success:function(response){
                if(response.error)
                {
                  if(response.error.nik)
                  {
                    $('#nik').addClass('is-invalid');
                    $('.errornik').html(response.error.nik);
                  }else{
                    $('#nik').addClass('is-valid');
                    $('#nik').removeClass('is-invalid');
                    $('.errornik').html();
                  }
                  
                  if(response.error.nama)
                  {
                    $('#nama').addClass('is-invalid');
                    $('.errornama').html(response.error.nik);
                  }else{
                    $('#nama').addClass('is-valid');
                    $('#nama').removeClass('is-invalid');
                    $('.errornama').html();
                  } 
                  if(response.error.email)
                  {
                    $('#email').addClass('is-invalid');
                    $('.erroremail').html(response.error.email);
                  }else{
                    $('#email').addClass('is-valid');
                    $('#email').removeClass('is-invalid');
                    $('.erroremail').html();
                  } 
                }else{
                    $('#exampleModal').modal('hide');
                    tabel.ajax.reload()
                    alert(response.suksess);
                }

                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>