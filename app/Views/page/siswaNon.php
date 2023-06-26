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
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun Lulus</label>
                        <div class="col-sm-3">
                            <select name="tahun" class="form-control" id="tahun">
                                <option value="">-Semua-</option>
                                <?php
                                    $sk = 2012;
                                    for($i=date('Y'); $i >= $sk; $i-=1){
                                        echo "<option value='$i'> $i </option>";
                                    }
                                    ?>
                            </select>
                        </div>
                        <label for="registrasi" class="col-sm-2 col-form-label">Pilih Sekolah</label>
                            <div class="col-sm-5">
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
                    <table class="table table-hover table-sm" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Tahun Keluar</th>
                                <th>Jenis Mutasi</th>
                                <th>Alasan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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
            info:     false,
            
            ajax: {
                    url : '/alumni',
                    data: function (d) {
                        d.tahun = $('#tahun').val();
                        d.lembaga = $('#lembaga').val();
                }
            },
            order :[],
            columns: [
                {data: 'nomor', orderable: false},
                {data : 'nama_siswa',sClass : 'text-center'},
                {data : 'nisn',sClass : 'text-center'},
                {data : 'created_at',sClass : 'text-center',
                    mRender: function (data, type, full) {
                        var dateAr = data.split('-');
                        return dateAr[0];
                    },
                },
                {data : 'jenis_alumni',sClass : 'text-center'},
                {data : 'alasan',sClass : 'text-center',},
                {
                    data : 'pindahke',sClass : 'text-center',
                    mRender: function (data, type, full) {
                        if(full['jenis_alumni']=='Mutasi'){
                            return 'Pindah Ke '+data
                        }else{
                            return '-';
                        }
                    }
                },
                {
                    data : 'id_alumni',
                    mRender: function (data, type, full) {
                        if(full['jenis_alumni']=='Mutasi'){
                            return '<button class="btn btn-sm btn-warning btn-icon ml-1 btnnipd"   id="'+data+'" data-toggle="tooltip" data-placement="left" title="Cetak Surat Mutasi"><i class="fas fa-print"></i></button>'
                        }else{
                            return '-';
                        }
                    }
                }
                
            ]
        });
        $('#tahun').change(function(event) {
            tabel.ajax.reload();
        });
        $('#lembaga').change(function(event) {
            tabel.ajax.reload();
        });
       
    })
</script>
<?= $this->endSection(); ?>