<div class="col-md-12">
    <h3>Data Kehadiran Karyawan <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h3>
    <hr>
    <?=$this->session->flashdata('pesan');?>
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
    <div class="table-responsive" style="margin-top: 20px">
      <?php
         if($data==true){
          $no=1;
          foreach ($data as $tampil){
          $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal),anchor('absensi/'.$tampil->tanggal.'/statistik','<i class="fa pencil-square-o"></i><span class="label label-info">Lihat Statistik</span>'));
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