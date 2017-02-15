<div class="col-md-12">
		<h3>Master Asuransi Karyawan</h3>
		<hr>
    <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>AsuransiController/hapus">
        <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
                $tanggal_input1 = $tampil->entry_date;
                $tanggal_input2 = substr($tanggal_input1, 0, 10);
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$tampil->asuransi,$tampil->vendor,$tampil->status,$tanggal_input2,anchor('AsuransiController/'.$tampil->id.'/edit','<i class="fa pencil-square-o"></i><span class="label label-warning">Edit</span>'));
            $no++;
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
        <div class="panel-footer">
           <?=anchor('AsuransiController/create','Tambah Data',['class' => 'btn btn-primary'])?>
            <!--<button class="btn btn-danger" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>-->
        </form>
        </div>
</div>