<div class="col-md-12">
    <h3>Master Data DP Cuti Karyawan <?=ucfirst($karyawan->nama_ktp)?></h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <form class="form-inline" name="formPrint" method="post" style="margin-bottom: 30px;" action="">
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bulan">
                <?php
                  $arr_bulan=explode(" ", $nama_bln);
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
          <button type="submit" class="btn btn-warning" id="btn-cetak" >Filter Data</button>
    </form>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>master-dp/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
      $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$this->format->BulanIndo(date('m',strtotime($tampil->tahun.'-'.$tampil->bulan))),$tampil->tahun,$tampil->saldo_dp,$tampil->saldo_cuti,$tampil->keterangan,anchor('master-dp/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>'));
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
        <button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>
        <button class="btn btn-warning" type="button" onclick="window.history.go(-1); return false;">Kembali</button>
      </form>
    </div>
</div>
