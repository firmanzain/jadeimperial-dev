<div class="col-md-12">
    <h4>Baca Data Jabatan</h4>
    <hr>
    <?php
    if(empty($hasil)){
        echo "Tidak ada data";
    }
    else{
    ?>
<table class="table table-bordered" id="example-2">
        <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Jabatan</b></td>
                <td><b>Status</b></td>
                <td><b>Fungsionalitas Sistem</b></td>
                <td><b>Keterangan</b></td>
                <td><b>Tanggal Input</b></td>                
                <td><b>Edit</b></td>
                <td><b>Delete</b></td>
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
                    <td><?php echo $data->jabatan;?></td>
                    <td><?php echo $data->status;?></td>
                    <td><?php echo $data->fungsionalitas;?></td>
                    <td><?php echo $data->keterangan_jabatan;?></td>
                    <td><?php echo $tanggal_input2;?></td>
                    <td><a href="<?=base_url()?>JabatanController/updatejabatan/<?php echo $data->id_jabatan ;?>"><span class="label label-warning">Edit</span></a></td>
                    <td><a href="<?=base_url()?>jabatanController/deletejabatan/<?php echo $data->id_jabatan ;?>" onclick="return warning()" ><span class="label label-danger">Hapus</span></a></td>
                </tr>
                <?php
                }
                ?>
                </table>
                <?php
                }
                ?>
        </tbody>
    <div class="form-group">
         <?=anchor('JabatanController/tambahjabatan','Tambah Data',['class' => 'btn btn-primary'])?>
    </div>
</div>