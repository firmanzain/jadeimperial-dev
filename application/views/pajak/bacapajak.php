<div class="row">
    <div class="col-md-12">
      <h4>Baca Data pajak</h4>
        <div class="table-responsive">
            <?php
            if(empty($hasil)){
                echo "Tidak ada data";
            }
            else{
            ?>
            <table class="table table-bordered">
                  <tr>
                    <td><b>No</b></td>
                    <td><b>Pajak</b></td>
                    <td><b>Keterangan Pajak</b></td>
                    <td><b>Gaji/Tahun</b></td>
                    <td><b>Gaji/Bulan</b></td>
                    <td><b>Tanggal Input</b></td>
                    <td><b>Edit</b></td>
                    <!--<td><b>Delete</b></td>-->
                </tr>
                <?php
                $no = 1;
                foreach($hasil as $data) {
                    $tanggal_input1 = $data->entry_date;
                    $tanggal_input2 = substr($tanggal_input1, 0, 10);    
                ?>
                <tr>
                    <td><?php echo $no++ ;?></td>
                    <td><?php echo $data->pajak;?></td>
                    <td><?php echo $data->keterangan_pajak;?></td>
                    <td><?php echo $this->format->indo($data->tarif);?></td>
                    <td><?php echo $this->format->indo($data->tarif_bulan);?></td>
                    <td><?php echo $tanggal_input2;?></td>
                    <td><a class="label label-success" href="<?php echo base_url('PajakController/updatepajak/'.$data->id_pajak) ;?>"><font color="white">Edit</font></a></td>
                    <!--<td><a class="label label-danger" onclick="return warning();" href="<?php echo base_url('pajakController/deletepajak/'.$data->id_pajak) ;?>"><font color="white">Delete</font></a></td>-->
                    </tr>
                
                <?php
                }
                ?>
                </table>
         
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <?=anchor('pajak/add','Tambah Data',['class' => 'btn btn-primary'])?>
        </div>  
    </div>
</div>
