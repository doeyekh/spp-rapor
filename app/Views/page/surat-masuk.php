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
            </div>
            <div class="card-body">
            <div class="form-group row">
                <label for="jk" class="col-sm-2 col-form-label">Sekolah / Lembaga</label>
                <div class="col-sm-4">
                    <select name="sch" id="sch" class="form-control form-control-sm ">
                        <?php foreach($sekolah as $lembaga): ?>
                                <option value="<?= $lembaga->id_lembaga; ?>" ><?= $lembaga->nama_sekolah; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label for="jk" class="col-sm-2 col-form-label">Tahun Pelajaran</label>
                <div class="col-sm-4">
                    <select name="thn" id="thn" class="form-control form-control-sm ">
                        
                        <?php foreach(alltahunajar() as $row): ?>
                                <option value="<?= $row['id_tahun']; ?>" <?= $row['status'] == 1 ? 'selected' : ''; ?>><?= $row['tahunpelajaran'] .' || '. $row['smt'] ; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
                    <table class="table table-hover table-sm" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Surat</th>
                                <th>Perihal</th>
                                <th>Pengirim</th>
                                <th>Tgl Surat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</section>

<!-- modal -->
<div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formuser" autocomplete="off">
        <div class="modal-body">
            <div class="form-group row">
                <label for="jk" class="col-sm-2 col-form-label">Sekolah / Lembaga</label>
                <div class="col-sm-10">
                    <select name="lembaga" id="lembaga" class="form-control form-control-sm ">
                        <?php foreach($sekolah as $lembaga): ?>
                                <option value="<?= $lembaga->id_lembaga; ?>" ><?= $lembaga->nama_sekolah; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="no" class="col-sm-2 col-form-label">No Surat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="nosurat" id="nosurat" placeholder="No Surat.." >
                    <div class="errorno invalid-feedback">
                        
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="perihal" class="col-sm-2 col-form-label">Perihal</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="perihal" id="perihal" placeholder="Perihal.." >
                    <div class="errorperihal invalid-feedback">
                        
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="tujuan" class="col-sm-2 col-form-label">Pengirim</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="tujuan" id="tujuan" placeholder="Pengirim  Surat.." >
                    <div class="errortujuan invalid-feedback">
                        
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="ket" class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="ket" id="ket" placeholder="ket Surat.." >
                    <input type="hidden" class="form-control"  name="jenis" id="jenis" value="Masuk">
                    <div class="errorket invalid-feedback">
                        
                    </div>
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

<!-- modal upload -->
<div class="modal fade" id="modalUpload"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formupload" autocomplete="off">
        <div class="modal-body">
            
            <div class="form-group row">
                <label for="file" class="col-sm-2 col-form-label lbl">Pilih Surat</label>
                <div class="col-sm-10">
                    <input type="hidden" class="form-control"  name="idsurat" id="idsurat" placeholder="Tujuan Surat.." >
                    <input type="file" class="form-control lbl"  name="fileupload" id="file" accept=".pdf , .PDF" >
                    <div class="errorfile invalid-feedback">
                        
                    </div>
                    <div class="embed-responsive embed-responsive-21by9 mt-2">
                        <iframe id="filepreview"  class="embed-responsive-item preview" src="" ></iframe>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-upload">Save changes</button>
            <button type="button" class="btn btn-warning btn-download">Save changes</button>
        </div>
      </form>
    </div>
  </div> 
</div>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax:  
        {
                    url : base_url + '/getsurat-masuk',
                    data: function (d) {
                        d.lembaga = $('#sch').val();
                        d.thn = $('#thn').val();
                }
            },

        order :[],
        columns: [
            {data : 'nomor',orderable:false},
            {data : 'no_surat'},
            {data:'perihal_surat'},
            {data:'tujuan'},
            {data:'tgl_surat'},
            {data:'ket_surat'},
            {
                data:'id_surat',
                mRender : function(data,type,full){
                    if(full['file_surat']==''){
                        return html = '<button id="'+data+'" class="btn btn-success btnUpload btn-sm"><i class="fas fa-upload"></i></button>';
                    }else{
                        return html = '<button id="'+full['file_surat']+'" class="btn btn-warning btnDownload btn-sm"><i class="fas fa-eye"></i></button>';

                    }
                }
            }
        ]
        }) 
        $('#sch').change(function(event) {
            tabel.ajax.reload();
        }); 
        $('#thn').change(function(event) {
            tabel.ajax.reload();
        }); 
        
        $(document).on('click','.btnUpload',function(){
            var id = $(this).attr('id');
            $('#modalUpload').modal('show');
            $('.modal-title').html('Upload Surat')
            $('.btn-upload').html('Upload')
            $('#idsurat').val(id);
            $('.lbl').show();
            $('.btn-upload').show()
            $('.btn-download').hide()
            $("#filepreview").attr("src",'');
        })

        $(document).on('click','.btnDownload',function(){
            var id = $(this).attr('id');
            $('#modalUpload').modal('show');
            $('.modal-title').html('Download Surat')
            $('.btn-upload').html('Upload')
            $('.btn-upload').hide()
            $('.lbl').hide();
            $('.btn-download').show()
            $('.btn-download').attr('id',id)
            $('.btn-download').html('Download')
            $("#filepreview").attr("src",base_url + '/assets/berkas/surat/'+ id);

        })

        $(document).on('click','.btn-download', function () {
        var id =$(this).attr('id');
        console.log(id);
        $.ajax({
            url: 'assets/berkas/surat/' + id,
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

        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url + '/surat',
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                success : function(respon){
                    console.log(respon)
                    if(respon.error){
                        if(respon.error.nosurat){
                            $('#nosurat').addClass('is-invalid');
                            $('.errorno').html(respon.error.nosurat)
                        }else{
                            $('#nosurat').removeClass('is-invalid');
                            $('.errorno').html()
                        }
                        if(respon.error.perihal){
                            $('#perihal').addClass('is-invalid');
                            $('.errorperihal').html(respon.error.perihal)
                        }else{
                            $('#perihal').removeClass('is-invalid');
                            $('.errorperihal').html()
                        }
                        if(respon.error.tujuan){
                            $('#tujuan').addClass('is-invalid');
                            $('.errortujuan').html(respon.error.tujuan)
                        }else{
                            $('#tujuan').removeClass('is-invalid');
                            $('.errortujuan').html()
                        }
                    }
                    if(respon.sukses){
                        iziToast.success({
                        title: 'Berhasil',
                        message: 'Surat Masuk Berhasil Di Arsipkan',
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

        $(document).on('submit','#formupload',function(e){
            e.preventDefault();
            $.ajax({
                url : base_url + '/upload-surat',
                method : 'post',
                data : new FormData(this),
                enctype : 'multipart/form-data',
                processData: false,
                contentType: false,
                cache : false,
                dataType : 'json',
                success : function(respon){
                    console.log(respon)
                    if(respon.error){
                        
                    }
                    if(respon.sukses){
                        iziToast.success({
                        title: 'Berhasil',
                        message: 'Surat Masuk Berhasil Di Arsipkan',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#formupload')[0].reset();
                    $('#modalupload').modal('hide');
                    tabel.ajax.reload(); 
                    }
                }
            })
        })


        $(document).on('change','#file',function () {
        const file = this.files[0];
        console.log(file)
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), ['pdf','PDF']) == -1) {
            $(this).addClass('is-invalid');
            $('.errorfile').html('Maaf File yang Diupload Bukan File PDF');
            // $("#filepreview").attr("src", "");
        } else {
            if (file && file.size <= 1276700) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $('.errorfile').html('');
                    $("#filepreview").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                $(this).addClass('is-invalid');
                $('.errorfile').html('File Terlalu Besar Maksimal 1,2 MB');
                $(this)[0].reset();
            }
        }
        });
       
    })
</script>
<?= $this->endSection(); ?>