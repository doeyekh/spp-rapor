<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4><a href="<?= base_url(); ?>siswa-ak" class="btn btn-success mr-3"> <i class="fas fa-caret-left"></i>  Kembali</a><?= $title; ?></h4>
    </div>
        <div class="section-body">
            <div class="row mt-sm-3">
                <div class="col-12 col-md-12 col-lg-3">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="<?= base_url(); ?>assets/img/siswa/<?= $siswa->foto; ?>" class="rounded-circle profile-widget-picture">
                        </div>
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
                    <h2 class="section-title">Riwayat Kelas</h2>
                    <div class="activities">
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                            <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                            <div class="mb-1">
                                <span class="text-job text-primary">2022/2023</span>
                                <span class="bullet"></span>
                                <a class="text-job" href="#">Ganjil</a>
                            </div>
                                <p>XII-RPL-1</p>
                            </div>
                        </div>
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                            <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                            <div class="mb-1">
                                <span class="text-job text-primary">2 min ago</span>
                                <span class="bullet"></span>
                                <a class="text-job" href="#">View</a>
                            </div>
                                <p>Have commented on the task of </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-9">
                    <div class="card">
                    <?php 
                  if(in_array('Operator',userLevel())): 
                  ?>
                        <div class="mt-3 mx-4">
                            <form action="" id="formRegister">
                                <div class="row">
                                    <label for="registrasi" class="col-sm-2 col-form-label">Pilih Sekolah</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <select name="registrasi" class="custom-select" id="">
                                                <?php foreach(getLembaga(['id_jenjang'=>$siswa->id_jenjang])->getResultArray() as $row): ?>
                                                    <option <?= $row['id_lembaga'] == $siswa->id_lembaga ? 'selected="selected"' : ''; ?> value="<?= $row['id_lembaga']; ?>"><?= $row['nama_sekolah']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btnregister">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <form action="" id="formUser">
                                <h2 class="section-title">Data Diri</h2>
                                <div class="form-group row">
                                    <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="nisn" id="nisn" value="<?= $siswa->nisn; ?>">
                                        <div class="errornisn error-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="nik" id="nik" value="<?= $siswa->nik; ?>">
                                        <div class="errornik error-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="nama" id="nama" value="<?= $siswa->nama_siswa; ?>">
                                        <div class="errornama error-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempat" class="col-sm-2 col-form-label">Tempat, Tgl Lahir</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control form-control-sm" name="tempat" id="tempat" value="<?= $siswa->tempat_lahir; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control form-control-sm" name="tgl" id="tgl" value="<?= $siswa->tgl_lahir; ?>">
                                    </div>
                                </div>

                                <h2 class="section-title">Domisili</h2>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <div class="text-muted">Masukan Alamat Nama JL /Kp/Dusun</div>
                                        <textarea name="alamat" id="alamat" class="form-control form-control-sm" cols="30"><?= $siswa->alamat; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rt" class="col-sm-2 col-form-label">RT / RW</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nomor RT</div>
                                        <input type="number" class="form-control form-control-sm" name="rt" id="rt" value="<?= $siswa->rt; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nomor RW</div>
                                        <input type="number" class="form-control form-control-sm" name="rw" id="tgl" value="<?= $siswa->rw; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="desa" class="col-sm-2 col-form-label">Desa/ Kecamatan</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nama Desa</div>
                                        <input type="text" class="form-control form-control-sm" id="desa" value="<?= $siswa->desa; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nama Kecamatan</div>
                                        <input type="text" class="form-control form-control-sm" id="tgl" value="<?= $siswa->kecamatan; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten / Provinsi</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Kabupaten / Kota</div>
                                        <input type="text" class="form-control form-control-sm" id="kabupaten" value="<?= $siswa->desa; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Provinsi</div>
                                        <input type="text" class="form-control form-control-sm" id="provinsi" value="<?= $siswa->kecamatan; ?>">
                                    </div>
                                </div>
                                <h2 class="section-title">Data Orang Tua</h2>
                                <div class="form-group row">
                                    <label for="namaayah" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nama Ayah</div>
                                        <input type="text" class="form-control form-control-sm" id="namaayah" value="<?= $siswa->nama_ayah; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Nama Ibu</div>
                                        <input type="text" class="form-control form-control-sm" id="namaibu" value="<?= $siswa->nama_ibu; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nikayah" class="col-sm-2 col-form-label">No NIK</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">NIK Ayah</div>
                                        <input type="number" class="form-control form-control-sm" id="nikayah" value="<?= $siswa->nik_ayah; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">NIK Ibu</div>
                                        <input type="number" class="form-control form-control-sm" id="nikaibu" value="<?= $siswa->nik_ibu; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pekerjaanayah" class="col-sm-2 col-form-label">Pekerjaan</label>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Pekerjaan Ayah</div>
                                        <input type="text" class="form-control form-control-sm" id="pekerjaanayah" value="<?= $siswa->pekerjaan_ayah; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="text-muted">Pekerjaan Ibu</div>
                                        <input type="text" class="form-control form-control-sm" id="pekerjaanibu" value="<?= $siswa->pekerjaan_ibu; ?>">
                                    </div>
                                </div>
                                <div class="alert alert-danger d-none">Data Gagal Diproses Harap Perbaiki Inian yang Berwarna merah</div>
                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <button type="submit" class="btn btn-primary btnupdate mr-1">Simpan</button>
                                    <input type="hidden" name="_method" value="PUT">
                                    <button type="button" class="btn btn-warning">Cetak</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
           
        
</section>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        $(document).on('submit','#formRegister',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url+'/updateregister/'+urlid,
                method : 'post',
                data : $(this).serialize(),
                beforeSend : function(e){
                    $('.btnregister').prop('disabled','disabled');
                    $('.btnregister').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(e){
                    $('.btnregister').removeAttr('disabled');
                    $('.btnregister').html(`Update`);
                },
                success : function(e){
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Registrasi Siswa Berhasil DiUpdate',
                        position: 'topRight',
                        timeout: 5000,
                        });
                        setInterval('location.reload()', 7000); 
                }
            })
        });

        $(document).on('submit','#formUpload',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url + '/siswa/'+urlid,
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
                            message: 'Registrasi Siswa Berhasil DiUpdate',
                            position: 'topRight',
                            timeout: 5000,
                        });
                    setInterval('location.reload()', 7000);
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
                }
            })
        })

        $(document).on('submit','#formUser',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url+'/siswa/'+urlid,
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                beforeSend : function(e){
                    $('.btnupdate').prop('disabled','disabled');
                    $('.btnupdate').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete : function(e){
                    $('.btnupdate').removeAttr('disabled');
                    $('.btnupdate').html(`Update`);
                },
                success : function(e){
                    console.log(e);
                    if(e.error){
                        $('.alert').removeClass('d-none');
                        if(e.error.nisn){
                            $('#nisn').addClass('is-invalid')
                            $('.errornisn').html(e.error.nisn)
                        }else{
                            $('#nisn').removeClass('is-invalid')
                            $('.errornisn').html()
                        }

                        if(e.error.nik){
                            $('#nik').addClass('is-invalid')
                            $('.errornik').html(e.error.nik)
                        }else{
                            $('#nik').removeClass('is-invalid')
                            $('.errornik').html()
                        }

                        if(e.error.nama){
                            $('#nama').addClass('is-invalid')
                            $('.errornik').html(e.error.nama)
                        }else{
                            $('#nama').removeClass('is-invalid')
                            $('.errornama').html()
                        }
                    }else{

                        iziToast.success({
                            title: 'Berhasil',
                            message: 'Biodata Siswa Berhasil Di Update',
                            position: 'topRight',
                            timeout: 5000,
                            });
                            setInterval('location.reload()', 7000); 
                    }
                }
            })
        });

    });
</script>
<?= $this->endSection(); ?>