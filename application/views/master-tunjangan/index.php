<div class="col-md-10">
    <h4>Data Master Tunjangan Karyawan</h4>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>MasterTunjangan/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
          $tanggal_input1 = $tampil->entry_date;
          $tanggal_input2 = substr($tanggal_input1, 0, 10);
      $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_tunjangan.'>',$no,$tampil->nama_tunjangan,$tampil->status,$this->format->BulanIndo(date('m',strtotime($tampil->bulan_ambil))),$tampil->status_tunjangan,$tanggal_input2,anchor('MasterTunjangan/'.$tampil->id_tunjangan.'/edit','<span class="label label-warning">Edit</span>'));
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
       <?=anchor('MasterTunjangan/create','Tambah Data',['class' => 'btn btn-primary'])?>
        <!--<button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>-->
      </form>
    </div>
</div>
