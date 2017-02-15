<div class="row">
    <div class="col-md-12">
        <h4>Halaman Data Department</h4>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>department/hapus">
        <div class="table-responsive">
            <?php
            if(empty($hasil)){
                echo "Tidak ada data";
            }
            else{
            ?>
             <table id="example-2" class="table table-bordered">
                <thead>
                <tr>
                    <td><b>No</b></td>
                    <td><b>Department</b></td>
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
                    <td><?php echo $data->department;?></td>
                    <td><?php echo $data->status;?></td>
                    <td><?php echo $data->keterangan_department;?></td>
                    <td><?php echo $tanggal_input2;?></td>
                    <td><a href="<?=base_url()?>DepartmentController/updatedepartment/<?php echo $data->id_department ;?>"><span class="label label-warning">Edit</span></a></td>
                    </td>
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
            <?=anchor('department/add','Tambah Data',['class' => 'btn btn-primary'])?>
        </div>
        </form>
    </div>
</div>
    
