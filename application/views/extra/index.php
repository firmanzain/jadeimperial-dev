<div class="col-md-12">
    <h3>Data Jam Kerja Ekstra Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h3>
    <hr>
      <form class="form-horizontal" id="form-periode" method="POST">
          <div class="form-group row">
            <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
              <div class="col-sm-4">
            <div class="input-daterange input-group" id="date-picker1">
                <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo $tgl1;?>" />
                <span class="input-group-addon">s/d</span>
                <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo $tgl2;?>" />
            </div>
              </div>
              <div class="col-sm-6 text-left">
                  <button type="submit" class="btn btn-primary">Filter</button>
              </div>
          </div>
      </form>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>ekstra/hapus">
      <div class="table-responsive" style="overflow: scroll;">
        <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        if (is_null($tampil->approved)) {
          $approve="Belum";
          $edit=anchor('ekstra/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>');
        } else {
          $approve=$tampil->approved;
          $edit='<span class="label label-danger">No Update</span>';
        }
        if($tampil->vakasi=='Dibayar' || $tampil->vakasi=='Ekstra Lain') $upah=$this->format->indo($tampil->jumlah_vakasi); else $upah=$tampil->jumlah_vakasi.' DP';
      $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$tampil->nik,$tampil->nama_ktp,$this->format->TanggalIndo($tampil->tanggal_ekstra),$tampil->jam_mulai.' s/d '.$tampil->jam_finish,$tampil->lama_jam.' Jam',$tampil->vakasi,$upah,$tampil->keterangan,$approve,$edit);
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      </div>
      <div class="panel-footer">
       <?=anchor('ekstra/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <!--<button class="btn btn-danger" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>-->
      </form>
    </div>
</div>