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
            
                <div class="table-responsive">
                    <table class="table table-hover" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenjang</th>
                                <th>Nama</th>
                                <th>Kepala / Koordinator</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="formuser" autocomplete="false">
        <div class="modal-body">
            <div class="form-group row">
                <label for="tingkat" class="col-sm-2 col-form-label">Tingkat</label>
                <div class="col-sm-10">
                    <select name="tingkat" class="form-control select2" id="tingkat" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <?php 
                        foreach ($jenjang as $data) :
                        ?>
                        <option value="<?= $data->id_jenjang; ?>"><?= $data->nama; ?></option>
                        <?php endforeach; ?>
                        
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="npsn" class="col-sm-2 col-form-label">NPSN</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="npsn"  id="npsn"  placeholder="No NPSN...">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="smt" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama"  id="nama"  placeholder="Nama Sekolah...">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="wakel" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select name="status" id="status" class="form-control select2">
                        <option value="">-- Pilih Status --</option>
                        <option value="1">Pusat</option>
                        <option value="0">Cabang</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="wakel" class="col-sm-2 col-form-label">Kepala / Koordinator</label>
                <div class="col-sm-10">
                    <select name="kepsek" id="kepsek" class="form-control select2">
                        <option value="">-- Pilih Guru --</option>
                        <?php foreach ($guru as $data) : ?>
                            <option value="<?= $data->id_guru; ?>"><?= $data->nama; ?></option>
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
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function()
    {
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/lembagaget',
        order :[],
        columns: [
            {data :'nomor', orderable: false},
            {data : 'namajenjang'},
            {data : 'nama_sekolah'},
            {data : 'nama'},
            {data: 'status', sClass: "text-center",
                mRender: function (data, type, full) {
                    if (full["status"] == "1") {
                        html = "<span class='badge badge-primary'>Pusat</span>";
                    } else {
                        html ="<span class='badge badge-success'>Cabang</span>";
                    }
                return html;
                },
            }
        ]
        });
        $(document).on('submit','#formuser',function(e)
        {
            e.preventDefault();
            $.ajax({
                url : '/lembaga',
                method : 'post',
                data : $(this).serialize(),
                success:function(data)
                {
                    $('#formuser')[0].reset();
                    $('#exampleModal').modal('hide');
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data Berhasil Disimpan',
                        position: 'topRight',
                        timeout: 5000,
                    });
                    tabel.ajax.reload();
                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>