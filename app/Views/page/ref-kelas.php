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
                    <div class="d-flex">
                        
                        <select name="level" id="level" class="form-control col-2 mb-2 mr-2">
                            <?php if(in_array('Administrator',userLevel())): ?>
                                <option value="">Semua</option>
                            <?php endif; ?>
                            <?php foreach($jenjang as $key): ?>
                                <option value="<?= $key->id_jenjang; ?>"><?= $key->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenjang</th>
                                <th>Tingkat</th>
                                <th>Kelas Akhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
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
            <div class="form-group row">
                <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-10">
                    <select name="jenjang" class="form-control" id="jenjang">
                        <option value="">-- Pilih Jenjang --</option>
                        <?php foreach($jenjang as $key): ?>
                            <option value="<?= $key->id_jenjang; ?>"><?= $key->nama; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="errorjenjang invalid-feedback">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama"  id="nama"  placeholder="Nama Kelas...">
                    <input type="hidden" class="form-control" name="idjenjang"  id="idjenjang">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="akhir" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="akhir" name="akhir">
                        <label class="form-check-label" for="akhir">
                          Kelas Tingkat Akhir
                        </label>
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
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                    url : '/refkelas',
                    data: function (d) {
                        d.jenjang = $('#level').val();
                }
            },
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data: 'nama'},
            {data: 'nama_tingkat'},
            {data: 'tingkat_akhir', sClass: "text-center",
                mRender: function (data, type, full) {
                    if(full['tingkat_akhir'] =='1'){
                        html ='<span class="btn btn-sm btn-icon btn-success"><i class="far fa-check-circle"></i></span>'
                    }else{
                        html ='<span class="btn btn-sm btn-icon btn-danger"><i class="fas fa-times-circle"></i></span>'
                    }
                    return html;
                },
            },
            {data: 'id_jenjangkelas', sClass: "text-center",
                mRender: function (data, type, full) {
                    
                    html ='<button class="btn btn-sm btn-primary btn-icon btn-edit" id="'+full['id_jenjangkelas']+'"  data-toggle="tooltip" data-placement="left" title="Edit Data"><i class="fas fa-edit"></i></button>'
                    
                    return html;
                },
            }
        ]
    });
    $('#level').change(function(event) {
        tabel.ajax.reload();
    });
        $(document).on('click','.btn-add',function(){
            $('.btn-save').html('Tambah')
            $('.modal-title').html('Tambah Data')
            $('#formuser')[0].reset()
        });
        $(document).on('click','.btn-edit',function(){
            var id = $(this).attr('id');
            $('.btn-save').html('Edit')
            $('.modal-title').html('Edit Data')
            $.ajax({
                url : '/refkelas',
                method : 'post',
                data : {id:id},
                dataType:'json',
                success:function(data){
                    console.log(data)
                    $('#exampleModal').modal('show');
                    $('#nama').val(data.nama_tingkat)
                    $('#id').val(data.id_jenjangkelas)
                    $('#jenjang').val(data.id_jenjang)
                    // $('#akhir').val(data.tingkat_akhir)
                    if(data.tingkat_akhir=='1'){
                        $('#akhir').prop('checked',true)
                    }else{
                        $('#akhir').prop('checked',false)

                    }
                }
            })
        })
        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
                url : '/ref-kelas',
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
                success:function(respon){
                    console.log(respon)
                    if(respon.error){
                        if(respon.error.jenjang){
                            $('#jenjang').addClass('is-invalid')
                            $('.errorjenjang').html(respon.error.jenjang)
                        }else{
                            $('#jenjang').removeClass('is-invalid')
                            $('.errorjenjang').html()
                        }
                        if(respon.error.nama){
                            $('#nama').addClass('is-invalid')
                            $('.errornama').html(respon.error.nama)
                        }else{
                            $('#nama').removeClass('is-invalid')
                            $('.errornama').html()
                        }
                    }
                    if(respon.berhasil){
                        $('#formuser')[0].reset();
                        iziToast.success({
                            title: 'Berhasil',
                            message: 'Referensi Kelas Berhasil Dibuat',
                            position: 'topRight',
                            timeout: 5000,
                        });
                        $('#exampleModal').modal('hide');
                        tabel.ajax.reload()
                    }
                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>