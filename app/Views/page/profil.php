<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4><?= $title; ?></h4>
        
    </div>
    <div class="section-body">

            <div class="row mt-sm-3">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="assets/img/avatar/<?= userLogin()->foto; ?>" class="rounded-circle profile-widget-picture">
                    </div>
                    <div class="profile-widget-description">
                        <form id="formUpload" action="" method="post">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" name="foto">
                                <label class="custom-file-label" for="foto">Pilih Gambar</label>
                                <div class="errorfoto invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-upload mt-2 mr-auto">Upload</button>
                        </form>
                    </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h5>Update Password</h5></div>
                        <div class="card-body">
                            <form id="formPassword">
                                <label for="">Password Lama</label>
                                <input type="password" class="form-control" name="passwordlama" id="passwordLama">
                                <div class="errorpasswordlama invalid-feedback"></div>
                                <label for="" class="mt-2">Password Baru</label>
                                <input type="password" class="form-control" name="passwordbaru" id="passwordBaru">
                                <div class="errorpasswordbaru invalid-feedback"></div>
                                <label for="" class="mt-2">Konfirmasi Baru</label>
                                <input type="password" class="form-control" name="konfirmasi" id="konfirmasi">
                                <div class="errorkonfirmasi invalid-feedback"></div>
                                <button type="submit" class="btn btn-primary mt-2 col-12 btn-pass">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Profil</h4>
                  </div>
                  <div class="card-body">
                    <form action="" id="formUser">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Biodata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Domisili</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Akun</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="number" name="nik" class="form-control-plaintext update" id="nik"   value="<?= userLogin()->nik; ?>" >
                                    <div class="errornik invalid-feedback">aasas</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext update" name="nama"  id="nama" value="<?= userLogin()->nama; ?>" >
                                    <div class="errornama invalid-feedback">aasas</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-sm-2 col-form-label">Tmp, Tgl Lahir</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control-plaintext update" name="tmp"  id="tmp" value="<?= userLogin()->tempat_lahir; ?>" >
                                </div>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control-plaintext update"  name="tgl" id="tgl" value="<?= userLogin()->tgl_lahir; ?>" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select name="jk" id="" class="form-control-plaintext update" >
                                        <option value="P" <?= userLogin()->jenis_kelamin =='P' ? 'selected="selected"' : ''; ?>>Perempuan</option>
                                        <option value="L" <?= userLogin()->jenis_kelamin =='L' ? 'selected="selected"' : ''; ?>>Laki-Laki</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group row">
                                <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                                <div class="col-sm-3">
                                    <input type="text" name="provinsi" id="provinsi" class="form-control-plaintext update"  value="<?= userLogin()->provinsi; ?>">
                                </div>
                                <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kabupaten" id="kabupaten" class="form-control-plaintext update"  value="<?= userLogin()->kabupaten; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan</label>
                                <div class="col-sm-3">
                                    <input type="text" name="kecamatan"  id="kecamatan" class="form-control-plaintext update"  value="<?= userLogin()->kecamatan; ?>">
                                </div>
                                <label for="desa" class="col-sm-2 col-form-label">Desa</label>
                                <div class="col-sm-5">
                                    <input type="text" name="desa" id="desa" class="form-control-plaintext update"  value="<?= userLogin()->desa; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext update" name="alamat"  id="alamat" value="<?= userLogin()->alamat; ?>" >
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="form-group row">
                                <label for="no_hp" class="col-sm-2 col-form-label">No Hp</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control-plaintext update" name="nohp"  id="nohp" value="<?= userLogin()->no_hp; ?>" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control-plaintext update" name="email"  id="email" value="<?= userLogin()->email; ?>" >
                                    <div class="erroremail invalid-feedback">aasas</div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <button type="button" class="btn btn-primary col-md-12 btn-edit">Edit</button>
                        <button type="submit" class="btn btn-primary col-md-12 btn-save">Simpan</button>
                    </form>
                  </div>
                  
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Berkas</h4>
                    </div>
                    <div class="card-body">
                    <button type="button" class="btn btn-primary btn-add mb-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-upload"></i> Upload
                </button>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableData">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Berkas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no =1; 
                                        foreach($berkas as $row): 
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['nama_berkas']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-icon btnDetail" id="<?= $row['file_berkas']; ?>" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>

                                                <button id="<?= $row['file_berkas']; ?>" class="btn btn-sm btn-success btn-icon btn-download" data-toggle="tooltip" data-placement="left" title="Download"><i class="fas fa-download"></i></button>
                                                <button id="<?= $row['file_berkas']; ?>" class="btn btn-sm btn-primary btn-icon btnedit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fas fa-edit"></i></button>
                                                <button id="<?= $row['id_berkas']; ?>" data-id="<?= $row['file_berkas']; ?>" class="btn btn-sm btn-danger btn-icon btn-hapus" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fas fa-trash"></i></button>
                                                
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach; 
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
</div>
           
        
</section>
<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="fileModalLabel">Detail Berkas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-21by9">
            <iframe class="embed-responsive-item embed" src="<?= base_url(); ?>assets/berkas/guru/" allowfullscreen></iframe>
        </div>
      </div>
      <div class="modal-footer">
      <button id="" class="btn btn-sm btn-success btn-icon btn-download" data-toggle="tooltip" data-placement="left" title="Download"><i class="fas fa-download"></i> Download</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formberkas">
        <div class="modal-body">
            
            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="namaberkas"  id="namaberkas"  placeholder="Nama Berkas...">
                    <div class="errornamaberkas invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                <div class="col-sm-10">
                    <input type="file" name="fileberkas" id="fileberkas" class="form-control">
                    <div class="errorfileberkas invalid-feedback">
                          
                    </div>
                    <iframe src="" width="370" height="200"  class="mt-1" id="prev"></iframe>
                    <div class="text-muted">File yang lebih dari 5 MB tidak akan Muncul</div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-s">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        $('.btn-save').hide();
        function filePreview(input) {
            const filePrev = document.querySelector('#prev')
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                filePrev.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).on('change','#fileberkas',function() {
            filePreview(this);
        });
        $(document).on('click','.btn-hapus',function(){
            var id = $(this).attr('id');
            var file = $(this).attr('data-id');
            console.log(id);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                   
                if (willDelete) {
                     $.ajax({
                       url : '/profil',
                        method : 'post',
                        data : {id:id,file:file,_method:'DELETE'},
                        dataType :'json',
                        beforeSend : function(e){
                        $('.swal-button--danger').prop('disabled','disabled');
                        $('.swal-button--danger').html(`<i class="fa fa-spin fa-spinner"></i>`);
                        },
                        complete : function(e){
                            $('.swal-button--danger').removeAttr('disabled');
                            $('.swal-button--danger').html(`Delete`);
                        },
                        success:function(e){
                            if(e.sukses){
                            iziToast.success({
                                title: 'Berhasil',
                                message: 'Berkas Berhasil Dihapus',
                                position: 'topRight',
                                timeout: 5000,
                            });
                            location.reload();
                        }
                        }
                    })
                } else {
                    swal("Your imaginary file is safe!");
                }
                });
        })
        $(document).on('click','.btnDetail',function(){
            var id = $(this).attr('id');
            $('#fileModal').modal('show');
            $('.embed').attr('src','assets/berkas/guru/'+id);
            $('.btn-download').attr('id',id);

        })
        $(document).on('click','.btn-edit',function(){
            $('.update').removeClass('form-control-plaintext')
            $('.update').addClass('form-control')
            $(this).hide();
            $('.btn-save').show();
    });
    $(document).on('click','.btn-download', function () {
        var id =$(this).attr('id');
        console.log(id);
        $.ajax({
            url: 'assets/berkas/guru/' + id,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = id;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            }
        });
    });
    $(document).on('submit','#formUpload',function(e){
        e.preventDefault();
        $.ajax({
            url : '/guru/upload',
            method : 'post',
            data : new FormData(this),
            enctype : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache : false,
            dataType : 'json',
            beforeSend : function(e){
                $('.btn-upload').prop('disabled','disabled');
                $('.btn-upload').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete : function(e){
                $('.btn-upload').removeAttr('disabled');
                $('.btn-upload').html(`Upload`);
            },
            success: function(respon){
                if(respon.error){
                    $('#foto').addClass('is-invalid');
                    $('.errorfoto').html(respon.error.foto);
                }else{
                    $('#foto').removeClass('is-invalid');
                    $('.errorfoto').html('');
                }
                if(respon.sukses){
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Foto Berhasil di Upload',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    location.reload();
                }
            },
            error:function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
            }
        })
    })
    $(document).on('submit','#formberkas',function(e){
        e.preventDefault();
        $.ajax({
            url : '/berkasguru',
            method : 'post',
            data : new FormData(this),
            enctype : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache : false,
            dataType : 'json',
            beforeSend : function(e){
                $('.btn-s').prop('disabled','disabled');
                $('.btn-s').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete : function(e){
                $('.btn-s').removeAttr('disabled');
                $('.btn-s').html(`Upload`);
            },
            success: function(respon){
                console.log(respon)
                if(respon.error){
                    if(respon.error.namaberkas){
                        $('#namaberkas').addClass('is-invalid');
                        $('.errornamaberkas').html(respon.error.namaberkas);
                    }else{
                        $('#namaberkas').removeClass('is-invalid');
                        $('#namaberkas').addClass('is-valid');
                        $('.errornamaberkas').html('');
                    }
                    if(respon.error.fileberkas){
                        $('#fileberkas').addClass('is-invalid');
                        $('.errorfileberkas').html(respon.error.fileberkas);
                    }else{
                        $('#fileberkas').removeClass('is-invalid');
                        $('#fileberkas').addClass('is-valid');
                        $('.errorfileberkas').html('');
                    }
                }
                if(respon.suksess){
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Foto Berhasil di Upload',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#formberkas')[0].reset();
                    location.reload();
                }
            },
            error:function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
            }
        })
    })

    $(document).on('submit','#formPassword',function(e){
        e.preventDefault();
        $.ajax({
            url :'/password',
            method : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            beforeSend : function(e){
                $('.btn-pass').prop('disabled','disabled');
                $('.btn-pass').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete : function(e){
                $('.btn-pass').removeAttr('disabled');
                $('.btn-pass').html(`Update`);
            },success : function(respon){
                console.log(respon)
                if(respon.error){
                    if(respon.error.passwordLama)
                        {
                            $('#passwordLama').addClass('is-invalid');
                            $('.errorpasswordlama').html(respon.error.passwordLama);
                        }else if(respon.error.passwordSalah)
                        {
                            $('#passwordLama').addClass('is-invalid');
                            $('.errorpasswordlama').html(respon.error.passwordSalah);
                        }else{
                            $('#passwordLama').addClass('is-valid');
                            $('#passwordLama').removeClass('is-invalid');
                            $('.errorpasswordLama').html();
                        }

                    if(respon.error.passwordBaru)
                        {
                            $('#passwordBaru').addClass('is-invalid');
                            $('.errorpasswordbaru').html(respon.error.passwordBaru);
                        }else{
                            $('#passwordBaru').addClass('is-valid');
                            $('#passwordBaru').removeClass('is-invalid');
                            $('.errorpasswordbaru').html();
                        }
                    if(respon.error.konfirmasi)
                        {
                            $('#konfirmasi').addClass('is-invalid');
                            $('.errorkonfirmasi').html(respon.error.konfirmasi);
                        }else{
                            $('#konfirmasi').addClass('is-valid');
                            $('#konfirmasi').removeClass('is-invalid');
                            $('.errorkonfirmasi').html();
                        }
                }
                if(respon.suksess){
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Password Berhasil diUpdate',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#formPassword')[0].reset();
                }
                if(respon.gagal){
                    iziToast.danger({
                        title: 'Gagal',
                        message: 'Password Gagal diUpdate',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#formPassword')[0].reset(); 
                }
            },error:function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
            }
        })
    })

        $(document).on('submit','#formUser',function(e){
            e.preventDefault();
            $.ajax({
            url : '/profile',
            method : 'post',
            data : $(this).serialize(),
            dataType : 'json',
            success:function(response){
                console.log(response);
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
                    $('.btn-save').hide();
                    $('.btn-edit').show();
                    alert(response.suksess);
                    $('.update').removeClass('form-control')
                    $('.update').addClass('form-control-plaintext')
                }

                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>