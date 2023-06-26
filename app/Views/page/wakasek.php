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
                    Salin Wakasek
                </button>
            <?php endif; ?>
            </div>
          
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="table table-hover" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Lembaga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
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
                <label for="guru" class="col-sm-2 col-form-label">Guru</label>
                <div class="col-sm-10">
                    <select name="guru" class="form-control select2" id="guru" required>
                        <option value="">-- Pilih Guru --</option>
                        <?php foreach ($guru as $key) : ?>
                            <option value="<?= $key->id_guru; ?>"><?= $key->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="guru" class="col-sm-2 col-form-label">Lembaga</label>
                <div class="col-sm-10">
                    <select name="lembaga" class="form-control select2" id="lembaga" required>
                        <option value="">-- Pilih Lembaga --</option>
                        <?php foreach ($lembaga as $key) : ?>
                            <option value="<?= $key->id_lembaga; ?>"><?= $key->nama_sekolah; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-10">
                    <select name="jabatan" id="jabatan" class="form-control select2">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php if(in_array('Operator',userLevel())): ?>
                            <option value="Kurikulum">Wk. Kurikulum</option>
                            <option value="Kesiswaan">Wk. Kesiswaan</option>
                            <option value="Bendahara">Wk. Bendahara</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Kepala Jurusan">Kepala Jurusan</option>
                        <?php endif; ?>
                        <option value="Operator">Operator</option>
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
                <label for="lmg" class="col-sm-2 col-form-label">Pilih Lembaga</label>
                <div class="col-sm-10">
                    <select name="lmg" id="lmg1" class="form-control">
                        <?php if(in_array('Administrator',userLevel())) :  ?>
                            <option value="">-Semua-</option>
                        <?php endif; ?>
                        <?php foreach(getLembaga()->getResultArray() as $row): ?>
                            <option value="<?= $row['id_lembaga']; ?>"><?= $row['nama_sekolah']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="errorlmg invalid-feedback"></div>
                </div>
            </div>
            <table class="table" id="tabelTarik">
                <thead>
                    <tr>
                        <th>
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                        </th>
                        <th>Nama</th>
                        <th>Lembaga</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
            </table>
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
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script src="assets/js/page/components-table.js"></script>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
            
        processing: true,
        serverSide: true,
        ajax: '/wakasekget',
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data : 'nama',sClass : 'text-center'},
            {data : 'jabatan',sClass : 'text-center'},
            {data : 'nama_sekolah',sClass : 'text-center'},
            {
                data: 'is_active', sClass: "text-center",
                mRender: function (data, type, full) {
                    html ='<button class="btn btn-sm btn-success btn-icon ml-1 btnPower" id="'+full['id_wakasek']+'" data-toggle="tooltip" data-placement="left" title="Non Aktifkan"><i class="fas fa-power-off"></i></button>'
                return html;
                    },
                }
            ]
        });
        $(document).on('click','.btn-tarik',function(){
            $('#tarikModal').modal('show')
            var tabeltarik = $('#tabelTarik').DataTable({
                lengthMenu: [5,10,20,50,100],
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url : '/wakasekold',
                    data: function (d) {
                        d.lembaga = $('#lmg1').val();
                }},
                order :[],
                columns: [
                {
                    data: 'nomor', orderable: false,
                    mRender: function(data,type,full){
                       html = '<div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup" class="custom-control-input chekbox" value="'+full['id_wakasek']+'" name="idguru" id="check-'+data+'"><label for="check-'+data+'" class="custom-control-label">&nbsp;</label> </div>'    
                        return html
                    }
                },
                {data : 'nama',sClass : 'text-center'},
                {data : 'jabatan',sClass : 'text-center'},
                {data : 'nama_sekolah',sClass : 'text-center'},
                    ]
            })
            $('#lmg1').change(function(event) {
                tabeltarik.ajax.reload();
            });
        })
         $(document).on('click','.btn-add',function(){
            $('.modal-title').html('Tambah Data');
            $('.btn-save').html('Simpan');
        });

        $(document).on('submit','#formtarik',function(e){
            e.preventDefault();
            var chekbox = $('.chekbox:checked');
            if(chekbox.length > 0 ){
                var checkbox_value = [];
                    $(chekbox).each(function(){
                        checkbox_value.push($(this).val());
                    });
                $.ajax({
                    method : 'post',
                    url : '/wakasekold',
                    dataType : 'json',
                    data :{
                        checkbox_value:checkbox_value,
                        _method : 'POST'
                    },
                    beforeSend : function(e){
                        $('.btn-simpan').prop('disabled','disabled');
                        $('.btn-simpan').html(`<i class="fa fa-spin fa-spinner"></i>`);
                    },
                    complete : function(e){
                        $('.btn-simpan').removeAttr('disabled');
                        $('.btn-simpan').html(`Salin Data`);
                    },
                    success: function(respon){
                        iziToast.success({
                            title: 'Berhasil',
                            message: respon.sukses.Berhasil +' Guru Berhasil Disalin ' + respon.sukses.gagal +' Gagal Disalin',
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
                    message: 'Silahkan Pilih Guru Terlebih Dahulu',
                    position: 'topRight',
                    timeout: 5000,
                });    
            }
        })

        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
            url : '/wakasek',
            method : 'post',
            dataType : 'json',
            data : $(this).serialize(),
            success:function(data){
                $('#exampleModal').modal('hide');
                tabel.ajax.reload()
                swal('Perhatian', 'Data Telah Berhasil Disimpan', 'success');
                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>