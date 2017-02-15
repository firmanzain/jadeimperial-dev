<div class="row">
    <div class="col-md-12">
    		<h4>Data Perizinan Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>perizinan/hapus">
            <?php
             if($data==true){
              $no=1;
              foreach ($data as $tampil){
              if ($tampil->pukul != "00:00:00") {
                  $pukul=$tampil->pukul;
                  $satuan=" Jam"; 
              } else {
                  $pukul="-----------";
                  $satuan=" Hari";
              }
              if (!empty($tampil->lampiran)) {
                $lampiran="<a href='".base_url().$tampil->lampiran."' target='blank'><span class='label label-info'>Show</span></a>";
                $tanggal=$this->format->TanggalIndo($tampil->tanggal_mulai).' s/d '.$this->format->TanggalIndo($tampil->tanggal_finish);
              } else {
                $lampiran="Kosong";
                $tanggal=$this->format->TanggalIndo($tampil->tanggal_mulai);
              }
              if($tampil->jenis_izin!="Tidak Dapat Masuk"){
              	$lama = "-".$satuan;
              } else {
              	$lama = $tampil->lama.$satuan;
              }
              //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jenis_izin,$tanggal,$lama,$tampil->alasan,$lampiran,$pukul,anchor('perizinan/'.$tampil->id.'/edit','<label class="label label-warning">Edit</label>'));
              $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jenis_izin,$tanggal,$lama,$tampil->alasan,$lampiran,$pukul);
              $no++;
              }
              $tabel=$this->table->generate();
              echo $tabel;
             }else {
                echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
             }
            ?>
        <div class="panel-footer">
           <?=anchor('perizinan/add','Tambah Data',['class' => 'btn btn-primary'])?>
            <button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>
        </form>
        <div align="right" style=" max-width:500px; float:right; padding-top:22px;"><?php if(isset($paginasi)) echo $paginasi; ?></div>
        </div>
    </div>
</form>