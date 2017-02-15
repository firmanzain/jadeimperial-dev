<h3>Data Peringatan Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h3>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
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
          <form name="form_data" method="post" id="form_data" action="<?=base_url()?>sp/hapus">
            <div class="table-responsive" id="show">
              <?php
                 if($data==true){
                  $no=1;
                  foreach ($data as $tampil){
                  if ($tampil->terima_bonus==0) {
                    $bonus = "Ya";
                  } else if ($tampil->terima_bonus==0) {
                    $bonus = "Tidak";
                  }
                  $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_sp,$no,$tampil->no_sp,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->jenis_sp,$this->format->TanggalIndo($tampil->tanggal_sp),$this->format->TanggalIndo($tampil->tanggal_sp_selesai),$bonus,$tampil->isi_sp,anchor('SpController/cetaksp/'.$tampil->id_sp.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div></span>',['target'=>'new']));
                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                 }
              ?>
            </div>
    </div>
    <div class="form-group">
        <?=anchor('sp/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>
    </div>
    </form>
</div>