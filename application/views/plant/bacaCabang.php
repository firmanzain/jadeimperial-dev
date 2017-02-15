<div class="row">
    <div class="col-md-12">
        <h4>Halaman Data Plant</h4>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>PlantController/hapus">
        <div class="table-responsive">
            <?php
                if(empty($hasil)){
                    echo "<div class='alert alert-danger'>Tidak ada data</div>";
                }
                else{
                ?>
                <table id="example-2" class="table table-bordered">
                    <thead>
                      <tr>
                        <td><b>No</b></td>
                        <td><b>Plant</b></td>
                        <td><b>Status</b></td>
                        <td><b>Keterangan</b></td>
                        <td><b>Tanggal Input</b></td>
                        <td><b>Edit</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach($hasil as $data) {
                    $tanggal_input1 = $data->entry_date;
                    $tanggal_input2 = substr($tanggal_input1, 0, 10);
                    ?>
                    <tr>
                        <td><?php echo $no++ ;?></td>
                        <td><?php echo $data->cabang;?></td>
                        <td><?php echo $data->status;?></td>
                        <td><?php echo $data->keterangan_cabang;?></td>
                        <td><?php echo $tanggal_input2;?></td>
                        <td><a href="<?=base_url()?>plant/edit/<?php echo $data->id_cabang ;?>"><span class="label label-warning">Edit</span></a></td>
                        </tr>
                    
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                }
                ?>
        </div>
        <div class="form-group">
            <?=anchor('plant/add','Tambah Data',['class' => 'btn btn-primary'])?>
        </div>
        </form>
    </div>
</div>  
    
