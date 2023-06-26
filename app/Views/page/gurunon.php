<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h4>Daftar Guru</h4>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="tableData">
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
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/guru',
        order :[],
        columns: [
            {data: 'nomor', orderable: false},
            {data: 'foto', sClass: "text-center",
                mRender: function (data, type, full) {
                    html = "<div class='avatar me-2'><img src='assets/img/avatars/"+full['foto']+"' alt='Avatar' class='rounded circle'></div>";
                return html;
                },
            },
            {data : 'nama',sClass : 'text-center'},
            {data : 'tempat_lahir',sClass : 'text-center',
                mRender : function(data,type,full)
                {
                    return full['tempat_lahir']+', '+full['tgl_lahir'];
                }
            },
            
            {data : 'email',sClass : 'text-center'},
            {data: 'status', sClass: "text-center",
                mRender: function (data, type, full) {
                    html ='<button class="btn btn-sm btn-danger btn-icon ml-1 btnPower" id="'+full['id_guru']+'" data-toggle="tooltip" data-placement="left" title="Aktifkan"><i class="fas fa-power-off"></i></button>'
                    return html;
                },
            }
        ]
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
                        url :'/guru-ak',
                        method : 'post',
                        data : {id:id,_method:'DELETE'},
                        success : function(data){
                            swal('Guru Telah Diaktifkan', {
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