
<div class="col-md-12">
    <h3>Data Rekapitulasi Bonus Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
    <hr>
      <form class="form-horizontal" id="form-periode" method="POST">
          <div class="form-group row">
            <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
              <div class="col-sm-4">
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
              </div>
              <div class="col-sm-4">
                <select class="form-control" name="tahun">
                    <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                  <?php
                    for ($i=2050; $i >= 2000 ; $i--) { 
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-2 text-left">
                  <button type="submit" class="btn btn-primary">Filter</button>
              </div>
          </div>
      </form>
      <?=$this->session->flashdata('pesan');?>
      <form method="post" id="form_data" action="<?=base_url('Laporan/ex_bonus')?>" target="new">
          <!--<input type="hidden" value="<?=$this->input->post('tanggal1')?>" name="tanggal1">
          <input type="hidden" value="<?=$this->input->post('tanggal2')?>" name="tanggal2">
          <input type="hidden" value="<?=$this->input->post('cabang')?>" name="cabang">-->
          <input type="hidden" name="bln" value="<?php echo $bln?>">
          <input type="hidden" name="thn" value="<?php echo $thn?>">


          <div class="table-responsive" style="overflow: scroll;">
      
          <?php
          /*if($data==true){
              $no=1;

              foreach ($data as $tampil){
                // first execution
                $jml_karyawan=$this->db->where('cabang',$tampil->id_cabang)->get('tab_karyawan')->num_rows();

                // second execution
                $this->table->add_row($no,$tampil->nama_cabang,$jml_karyawan,$this->format->indo($tampil->omset),$this->format->indo($tampil->bruto),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($tampil->bonus_prosen),$this->format->indo($tampil->bonus_nominal),$this->format->indo($tampil->bonus_pure),$this->format->indo($tampil->bonus_point),$this->format->indo($tampil->bonus_prorata),$tampil->approved,$tampil->keterangan,anchor('bonus/'.$tampil->id_cabang.'/'.$bln.'/'.$thn.'/detailrekap','<span class="label label-warning">Detail</span>'));

                // third execution
                $no++;
              }

              $tabel=$this->table->generate();
              echo $tabel;
          }
          else 
          {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          }*/
          if($data==true){
          $no=1;
          foreach ($data as $tampil){
            $data2 = $this->bonus->detail($tampil->id_omset,$bln,$thn);

            $sum_total_bonus = 0;
            $sum_total_bulat = 0;
            $sum_total_kembali = 0;
            $sum_total_bonus2 = 0;

            foreach ($data2 as $tampil2){
              if ($tampil2->nik_bonus!=NULL) {

              //SUM
              $sum_total_bonus += $tampil2->total_bonus;
              $sum_total_bulat += $tampil2->total_bulat;
              $sum_total_kembali += $tampil2->total_kembali;
              $sum_total_bonus2 += $tampil2->total_diterima;
              }
            }

            $this->table->add_row($no,$tampil->nama_cabang,$this->format->indo($tampil->omset),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($sum_total_bonus),$this->format->indo($sum_total_bulat),$this->format->indo($sum_total_bonus-$sum_total_bulat),$this->format->indo($sum_total_bonus2),$this->format->indo($sum_total_kembali),$tampil->approved,anchor('bonus/'.$tampil->id_cabang.'/'.$bln.'/'.$thn.'/detailrekap','<span class="label label-warning">Detail</span>'));
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
            <!--<button type="submit" name="btn_aksi" value="cetak" class="btn btn-primary">
              Print All Data
            </button>-->
            <button type="submit" name="btn_aksi" value="excel" class="btn btn-success">
              Export Excel
            </button>
          </div>
      </form>
    </div>  
  </div>


<script type="text/javascript">
  $( document ).ready(function() {
  });
  function cetak(a) {
  sUrl="<?=base_url()?>bonus/"+a+"/print"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>