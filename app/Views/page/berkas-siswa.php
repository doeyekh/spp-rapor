<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4><?= $title; ?></h4>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div class="mx-2">
                    <div class="form-group row">
                        
                        <label for="registrasi" class="col-sm-2 col-form-label">Pilih Sekolah</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <select name="lembaga" class="form-control" id="lembaga">
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
                </div>
                    <table class="table table-bordered table-hover table-sm text-center" id="tableData">
                        <thead>
                            <tr>
                                <th rowspan = "2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="8">Berkas Siswa</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>IJAZAH</th>
                                <th>SKHU</th>
                                <th>KK</th>
                                <th>AKTA</th>
                                <th>KTP AYAH</th>
                                <th>KTP IBU</th>
                                <th>KIP</th>
                                <th>KIS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</section>


<div class="modal fade" id="berkasmodal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close keluar" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formuser" autocomplete="off">
        <div class="modal-body">
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control disabled" name="nama"  id="nama"  placeholder="Nama Lengkap...">
                    <input type="hidden" class="form-control" name="idsiswa"  id="idsiswa">
                    <input type="hidden" class="form-control" name="action"  id="action">
                    <div class="text-muted label-note">  Hanya File PDF yang Diperbolehkan Maksimal Ukuran 1,2 Mb</div>
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="text-muted text-center mb-1 text-title">Ijazah</div>
                    <input type="file" class="form-control mb-1" id="ijazah" name="ijazah">
                    <input type="file" class="form-control mb-1" id="skhun" name="skhun">
                    <input type="file" class="form-control mb-1" id="kk" name="kk">
                    <input type="file" class="form-control mb-1" id="akta" name="akta">
                    <input type="file" class="form-control mb-1" id="ktp_ayah" name="ktp_ayah">
                    <input type="file" class="form-control mb-1" id="ktp_ibu" name="ktp_ibu">
                    <input type="file" class="form-control mb-1" id="kip" name="kip">
                    <input type="file" class="form-control mb-1" id="kis" name="kis">
                    <div class=" invalid-feedback">
                    </div>
                    
                    <div class="embed-responsive embed-responsive-21by9">
                        <iframe  class="embed-responsive-item preview" src="" ></iframe>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary keluar">Close</button>
            <button type="submit" class="btn btn-primary btn-save">Upload</button>
            <button type="button" class="btn btn-success btn-unduh"><i class="fas fa-download"></i> Download</button>
        </div>
      </form>
    </div>
  </div>
  
</div>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        load();
        function load(){
            $('#ijazah').hide()
            $('#skhun').hide()
            $('#kk').hide()
            $('#akta').hide()
            $('#ktp_ayah').hide()
            $('#ktp_ibu').hide()
            $('#kip').hide()
            $('#kis').hide()
            $('.preview').attr('src','');
        }
        $('.keluar').click(function () {
            $('#berkasmodal').modal('hide')
            $('#formuser')[0].reset()
            
            $('.invalid-feedback').html('');
            load();
        })
        var tabel = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            "autoWidth": false,
            ajax: {
                    url : '/berkasget',
                    data: function (d) {
                        d.lembaga = $('#lembaga').val();
                }
            },
            order :[],
            columns: [
            {data: 'nomor', orderable: false},
            {data: 'nama_siswa', sClass: 'text-center'},
            {
                data: 'ijazah', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-sm btn-icon btn-danger btn-ijazah"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-ijazah"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'skhun', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-skhu btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-skhun"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'kk', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-kk btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-kk"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'akta', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-akta btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-akta"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'ktp_ayah', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-ktpayah btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-ktpayah"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'ktp_ibu', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-ktpibu btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-ibu"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'kip', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-kip btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-kip"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                } 
            },
            {data: 'kis', sClass: 'text-center',
                mRender : function(data,type,full){
                    if(data==''){
                        return '<span data-nama="'+full['nama_siswa']+'" id="'+full['id_berkassiwa']+'" class="btn btn-kis btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i> Upload</span>'
                    }else{
                        html=  '<button data-nama="'+full['nama_siswa']+'" class="btn btn-sm btn-success btn-icon ml-1 detail-kis"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Detail"><i class="fas fa-eye"></i></button>'
                        html +='<button class="btn btn-sm btn-info btn-icon ml-1"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Edit Berkas"><i class="fas fa-edit"></i></button>'
                        return html;
                    }
                }
            },
            {data: 'id_berkassiwa', sClass: 'text-center',
                mRender : function(data,type,full){
                    return '<button type="button" data-nama="'+full['nama_siswa']+'" id="'+data+'" class="btn btn-success bnt-sm btnUpload mb-2"><i class="fas fa-eye"></i></button>'
                }
            },
        ]
        });
    $('#lembaga').change(function(event) {
        tabel.ajax.reload();
    });

    $(document).on('submit','#formuser',function(e){
        e.preventDefault();
        var action = $('#action').val();
        $.ajax({
            url : base_url + '/berkas/' + action,
            method : 'post',
            data : new FormData(this),
            enctype : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache : false,
            dataType : 'json',
            beforeSend : function(e){
                $('.btn-save').prop('disabled','disabled');
                $('.btn-save').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete : function(e){
                $('.btn-save').removeAttr('disabled');
                $('.btn-save').html(`Upload`);
            },
            success: function(respon){
                if(respon.sukses){
                    $('.preview').attr('src','');
                    load();
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Berhasil diUpload',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    $('#berkasmodal').modal('hide');
                    
                    tabel.ajax.reload();
                }
            },
            error:function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
            }
        })
    })
    

    // $(document).on('click','.btnUpload',function(){
    //     var nama = $(this).attr('data-nama');
    //     var id = $(this).attr('id');
    //     $.ajax({
    //         url : base_url + '/berkasget',
    //         method : 'post',
    //         data : {id:id,_method:'PUT'},
    //         dataType : 'json',
    //         success : function(e){
    //             console.log(e);
    //             $('#ktpayahpreview').attr('src','/assets/berkas/siswa/ktpayah/'+e.ktp_ayah);
    //             $('#ktpibupreview').attr('src','/assets/berkas/siswa/ktpibu/'+e.ktp_ibu);
    //             $('#ijazahpreview').attr('src','assets/berkas/siswa/ijazah/'+e.ijazah);
    //             $('#skhupreview').attr('src','assets/berkas/siswa/skhu/'+e.skhun);
    //             $('#kkpreview').attr('src','assets/berkas/siswa/kk/'+e.kk);
    //             $('#aktapreview').attr('src','assets/berkas/siswa/akta/'+e.akta);
    //             $('#exampleModal').modal('show');
    //             $('#nama').val(nama);
    //             $('#idsiswa').val(id);
    //         }
    //     })
    // })
    
    uploadfile("btn-ijazah","ijazah","ijazahpreview","errorijazah")
    uploadfile("btn-skhu","skhun","skhupreview","errorskhu")
    uploadfile("btn-kk","kk","kkpreview","errorkk")
    uploadfile("btn-akta","akta","aktapreview","errorakta")
    uploadfile("btn-ktpayah","ktp_ayah","ktpayahpreview","errorktpayah")
    uploadfile("btn-ktpibu","ktp_ibu","ktpibupreview","errorktpibu")
    uploadfile("btn-kip","kip","kippreview","errorkip")
    uploadfile("btn-kis","kis","kispreview","errorkis")
    function uploadfile(id,file,previewId,errorClass){
        $(document).on('click','.'+id,function(){
            $('.text-title').html(file)
            $('#berkasmodal').modal('show');
            var nama = $(this).attr('data-nama');
            var id = $(this).attr('id');
            $('#nama').val(nama);
            $('#idsiswa').val(id);
            $('.preview').attr('id',previewId);
            $('.invalid-feedback').addClass(errorClass);
            $('#'+file).show();
            $('.modal-title').html('Upload '+file)
            $('#action').val(file)
            $('.btn-save').show();
            $('.btn-unduh').hide();
            $('.label-note').show();
        })
    }

    detailfile("detail-kis","kis")
    detailfile("detail-kip","kip")
    detailfile("detail-ktpayah","ktp_ayah")
    detailfile("detail-ktpibu","ktp_ibu")
    detailfile("detail-akta","akta")
    detailfile("detail-kk","kk")
    detailfile("detail-skhun","skhun")
    detailfile("detail-ijazah","ijazah")
    function detailfile(name,label){
        $(document).on('click','.'+name,function(){
            $('.text-title').html('Detail '+label)
            $('#berkasmodal').modal('show');
            $('#action').val(label)
            var nama = $(this).attr('data-nama');
            var id = $(this).attr('id');
            $('#nama').val(nama);
            $('.preview').attr('src','assets/berkas/siswa/'+label +'/'+id);
            $('.modal-title').html('Detail '+label)
            $('.btn-save').hide();
            $('.btn-unduh').show();
            $('.btn-unduh').attr('id',id);
            $('.label-note').hide();
        })
    }
        

        $(document).on('click','.btn-unduh', function () {
        var id =$(this).attr('id');
        var action = $('#action').val()
        console.log(id);
        $.ajax({
            url: 'assets/berkas/siswa/'+ action +'/' + id,
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
        

    handleFileUpload("ijazah", "ijazahpreview", "errorijazah", ['pdf', 'PDF']);
    handleFileUpload("skhun", "skhupreview", "errorskhu", ['pdf', 'PDF']);
    handleFileUpload("kk", "kkpreview", "errorkk", ['pdf', 'PDF']);
    handleFileUpload("akta", "aktapreview", "errorakta", ['pdf', 'PDF']);
    handleFileUpload("ktp_ayah", "ktpayahpreview", "errorktpayah", ['pdf', 'PDF']);
    handleFileUpload("ktp_ibu", "ktpibupreview", "errorktpibu", ['pdf', 'PDF']);
    handleFileUpload("kip", "kippreview", "errorkip", ['pdf', 'PDF']);
    handleFileUpload("kis", "kispreview", "errorkis", ['pdf', 'PDF']);

    function handleFileUpload(id, previewId, errorClass, fileExtension) {
    $("#" + id).change(function () {
        const file = this.files[0];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).addClass('is-invalid');
            $('.' + errorClass).html('Maaf File yang Diupload Bukan File PDF');
        } else {
            if (file && file.size <= 1276700) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $('.' + errorClass).html('');
                    $("#" + previewId).attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                $(this).addClass('is-invalid');
                $('.' + errorClass).html('File Terlalu Besar Maksimal 1,2 MB');
                $(this)[0].reset();
            }
        }
    });
    }

       
    })
</script>
<?= $this->endSection(); ?>