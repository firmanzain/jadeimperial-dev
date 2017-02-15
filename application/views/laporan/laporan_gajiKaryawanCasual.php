<!--Ini yang pas transaksi gaji diklik => tampilkan rekap gaji per cabang-->

<div class="col-md-12">
    <h4>Halaman Rekap Penggajian Casual Karyawan Bulan <?=$this->format->BulanIndo($bln)?> Tahun <?=$thn?></h4>
    <hr>
    <form class="form-inline" name="formPrint" method="post" action="">
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bln">
                <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
                <?php 
                  $arr_bln = "Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember";
                  $bln1 = explode(",", $arr_bln);
                  for ($i=1; $i <=12 ; $i++) {
                    echo '<option value="'.$i.'">'.$bln1[$i-1].'</option>'; 
                  }
                ?>
              </select>
              <label class="m-r-10">Tahun</label>
              <select class="form-control" name="tahun">
                  <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                <?php
                  for ($i=2050; $i >= 2000 ; $i--) { 
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                ?>
              </select>
          </div>
          <button type="submit" class="btn btn-warning" id="btn-cetak" >Filter Data</button>
    </form>
    <form method="post" action="<?=base_url('Laporan/ex_gaji_casual')?>" target="new">
    <input type="hidden" name="bln" value="<?php echo $bln?>">
    <input type="hidden" name="thn" value="<?php echo $thn?>">
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
        if($pph!=0) {
          if ($data==true) {
            $no=1;
            foreach ($data as $val) {
              $this->table->add_row($no,$val->cabang,$val->jml,$this->format->indo($val->gaji_netto),$this->format->indo($val->uang_makan_real),$this->format->indo($val->ekstra),$this->format->indo($val->pph),$this->format->indo($val->t_gaji_terima),$this->format->indo($val->gaji_netto2),$this->format->indo($val->uang_makan_real2),$this->format->indo($val->ekstra2),$this->format->indo($val->pph2),$this->format->indo($val->t_gaji_terima2),$this->format->indo($val->t_gaji_terima + $val->t_gaji_terima2),"<a class='label label-warning' href='".base_url()."gaji/".$bln."/".$thn."/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/detailrekapcasual'>Detail</a>");
              $no++;
            }
              
            $tabel = $this->table->generate();
            echo $tabel;
          } else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>"; 
          }
        } else {
          echo "<div class='alert alert-warning'>Silahkan insert pph terlebih dahulu</div>";
        }
      ?>
    </div>

    <div class="form-group">
      <button class="btn btn-success" type="submit">Export Excel</button>
    </div>
    </form>
</div>
<script>
</script>