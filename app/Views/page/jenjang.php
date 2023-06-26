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
                                <th>Nama</th>
                                <th>Jenis</th>
                                
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
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama"  id="nama"  placeholder="Nama Jenjang...">
                    <div class="errornama invalid-feedback">
                          
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                <div class="col-sm-10">
                    <select name="jenis" id="jenis" class="form-control select2">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="formal">Formal</option>
                        <option value="Non Formal">Non Formal</option>
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
        ajax: '/jenjangget',
        order :[],
        columns: [
            {data :'nomor', orderable: false},
            {data : 'nama'},
            {data : 'status'}
        ]
        });
        $(document).on('submit','#formuser',function(e)
        {
            e.preventDefault();
            $.ajax({
                url : '/jenjang',
                method : 'post',
                dataType : 'json',
                data : $(this).serialize(),
                success: function(data)
                {
                    console.log(data);
                    if(data.error)
                    {
                        if(data.error.nama)
                        {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(data.error.nama);
                        }else{
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html('');

                        }
                    }
                    if(data.sukses)
                    {
                        iziToast.success({
                        title: 'Berhasil',
                        message: data.sukses,
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
    });
</script>
<?= $this->endSection(); ?>