<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4>Tahun Pelajaran</h4>
    </div>
    <div class="section-body">
       <div class="card">
        <div class="card-header">
        <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#exampleModal">
            Tambah
        </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
       </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" readonly name="tahun" id="tahun"  value="<?= $tahun; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="smt" readonly id="smt" value="<?= $smt; ?>">
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
<?= $this->section('js') ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/tahunajar',
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data: 'tahunpelajaran', sClass: "text-center"},
            {data : 'smt',sClass : 'text-center',
            },
            {data: 'status', sClass: "text-center",
                mRender: function (data, type, full) {
                    if (full["status"] == "2") {
                        html = "<button class='btn btn-danger btn-sm btn-status' data-id='" +full["id_tahun"]+"' data-status='" + full["status"] + "'>Non Aktif</button>";
                    } else {
                        html ="<button class='btn btn-success btn-sm'>Aktif</button>";
                    }
                return html;
                },
            }
        ]
    });
        $(document).on('click','.btn-add',function(){
            $('.modal-title').html('Tambah Data');
            $('.btn-save').html('Simpan');
        });
        $(document).on('click','.btn-status',function(){
        var status = $(this).attr('data-status');
        var idtahun = $(this).attr('data-id');
        $.ajax({
            url : 'tahunpelajaran',
            method : 'post',
            data : {status:status,idtahun:idtahun},
            success : function(data){
                tabel.ajax.reload();
            }
        });
    });

        $(document).on('submit','#formuser',function(e){
            e.preventDefault();
            $.ajax({
            url : '/tahun-ajar',
            method : 'post',
            data : $(this).serialize(),
            success:function(data){
                // $(".txt_csrfname").val(response.token);
                $('#exampleModal').modal('hide');
                tabel.ajax.reload()
                if(data==1){
                    swal('Sorry', 'Anda Tidak Bisa Menambahkan Data Yang Sudah Ada', 'error');
                }else{
                    swal('Perhatian', 'Data Telah Berhasil Disimpan', 'success');
                }
            }
        })
    })
})
</script>
<?= $this->endSection() ?>

