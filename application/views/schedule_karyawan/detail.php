<div class="col-md-12">
<h4>Detail Schedule Karyawan : <?= ucfirst($karyawan->nama_ktp) ?> <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<!--<form class="form-inline" name="formPrint" method="post" action="">
    <div class="form-group m-r-20">
        <label class="m-r-10">Bulan</label>
        <select class="form-control" name="bulan">
          <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
          <?php
            for ($i=1; $i <=12 ; $i++) { 
              echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
            }
          ?>
        </select>
    </div>
    <div class="form-group m-r-20">
        <label class="m-r-10">Tahun</label>
        <select class="form-control" name="tahun">
            <option selected><?=date("Y")?></option>
          <?php
            for ($i=2050; $i >= 2000 ; $i--) { 
              echo "<option>$i</option>";
            }
          ?>
        </select>
    </div>
    <button type="submit" class="btn btn-warning" id="btn-cetak">Filter Data</button>
</form>-->
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
    <form name="form_data" method="post" id="form_data" action="<?=base_url()?>shedule-karyawan/hapus">
      <div class="table-responsive" style="margin-top: 20px;">
              <?php
                 if($data==true){
                  $link=$this->session->set_flashdata('link',current_url());
                  $no=1;
                  foreach ($data as $tampil){
                    if ($tampil->kode_jadwal==NULL) {
                      $cell = '<span class="label label-danger">Jadwal tidak valid</span>';
                    } else {
                      $cell = "";
                    }
                  $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_jadwal.'>',$no,$this->format->TanggalIndo($tampil->tanggal),$tampil->kode_jam,$tampil->jam_start,$tampil->jam_finish,$tampil->jam_start2,$tampil->jam_finish2,anchor('shedule-karyawan/'.$tampil->id_jadwal.'/edit','<span class="label label-warning">Edit</span>').$cell);
                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                 }
              ?>
      </div>
      <div class="form-group">
        <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
          <!--<?=anchor('shedule-karyawan/add','Tambah Data',['class' => 'btn btn-primary'])?>
          <button class="btn btn-info" type="button" onClick="importData()">Import Data</button>
          <button class="btn btn-danger delete" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>-->
      </div>
    </form>
</div>
<script>
function importData() {
  sUrl="<?=base_url()?>schedule/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>
