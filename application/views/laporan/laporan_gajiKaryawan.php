<div class="col-md-12">
    <h4>Rekapitulasi Gaji Karyawan Bulan <?=$this->format->BulanIndo($bln)?></h4>
    <hr>
    <hr>
    <form class="form-inline" name="formPrint" method="post" action="">
              <div class="form-group m-r-20">
                  <label class="m-r-10">Bulan</label>

                  <select class="form-control" name="bln">
                    <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
                    <?php 
                      $arr_bln = "Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember";
                      // explode is used to explode string into array based on the delimiter
                      $bln1 = explode(",", $arr_bln);
                      for ($i=1; $i <=12 ; $i++) {
                        echo '<option value="'.$i.'">'.$bln1[$i-1].'</option>'; 
                      }
                    ?>
                  </select>
                  &nbsp;&nbsp;
                  <label class="m-r-10">Tahun</label>
                  <select class="form-control" name="tahun">
                      <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                    <?php
                      for ($i=2050; $i >= 2000 ; $i--) { 
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                    ?>
                  </select>&nbsp;&nbsp;
                  <button class="btn btn-primary" id="ft-data">Filter Data</button>
              </div>
              <!--<div class="input-group date" id="date-picker1">
                  <input type="text" name="tanggal1" class="form-control">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
              </div>-->
          <!--<div class="form-group m-r-20">
              <label class="m-r-10">Sampai Tanggal</label>
              <div class="input-group date" id="date-picker2">
                  <input type="text" name="tanggal2" class="form-control">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
              </div>
          </div>-->
          <!--<button type="submit" class="btn btn-warning" id="btn-cetak" >Filter Data</button>-->
    </form>
    <form method="post" action="<?=base_url('Laporan/ex_gaji')?>" target="new">
      <!--<input type="hidden" name="tgl1" value="<?=$this->input->post('tanggal1')?>">
      <input type="hidden" name="tgl2" value="<?=$this->input->post('tanggal2')?>">-->
      <input type="hidden" name="bln" value="<?php echo $bln?>">
      <input type="hidden" name="thn" value="<?php echo $thn?>">
      <div class="table-responsive" style="overflow: scroll; margin-top: 10px;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      //var_dump($gaji);
      if ($gaji==true) {
        $no=1;
        foreach ($gaji as $val) {

          $this->table->add_row($no,$val->cabang,$val->field1,$this->format->indo($val->field2),$this->format->indo($val->field3),$this->format->indo($val->field4),$this->format->indo($val->field5),$this->format->indo($val->field6),$this->format->indo($val->field7),$this->format->indo($val->field14),$this->format->indo(round(($val->field10/10),0,PHP_ROUND_HALF_UP)*10),$this->format->indo(round(($val->field10/10),0,PHP_ROUND_HALF_UP)*10),"<a class='label label-warning' href='".base_url()."gaji/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/".$bln."/".$thn."/detailrekap'>Detail</a>");

          $no++;
        }
        
        $tabel = $this->table->generate();
        echo $tabel;
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button class="btn btn-success" type="submit">Export Excel</button>
    </div>
    </form>
</div>
