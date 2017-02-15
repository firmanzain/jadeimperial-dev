<div class="row">
  <div class="col-md-12">
    <h4>Data Karyawan Pengangkatan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
      <form name="form_data" method="post" id="form_hasil" action="PengangkatanController/hapus">  
          <div class="table-responsive" id="show">
            <?php
               if($data==true){
                $no=1;
                foreach ($data as $tampil){
                $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_pangkat.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->status1,$tampil->status_kerja,$tampil->jabatan1,$tampil->jabatan,$tampil->department1,$tampil->department,$tampil->cabang,$this->format->TanggalIndo($tampil->entry_date),anchor('PengangkatanController/cetakpengangkatan/'.$tampil->id_pangkat.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div></span>',['target'=>'new']));
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
            <?=anchor('PengangkatanController/create','Tambah Data',['class' => 'btn btn-primary'])?>
            <button type="submit" class="btn btn-danger" onclick="return warning()" >Hapus Data</button>
        </div>
    </form>
  </div>
</div>