<div class="col-md-12">
    <h3>Data Bonus Karyawan Baru Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
                    <option value="<?=$thn?>"><?=$thn?></option>
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
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>BonusBaru/rekapData">
      <input type="hidden" name="bln" value="<?php echo $bln?>">
      <input type="hidden" name="thn" value="<?php echo $thn?>">
      <div class="table-responsive" style="overflow: scroll;">
      
        <?php
        if($data == true){
            $no=1;

            foreach ($data->result() as $tampil){
              if ($tampil->approved == 0) {
                $approved = "Belum";
                $delete_btn = "";
              } else if ($tampil->approved == 1) {
                $approved = "Tidak Disetujui";
                $delete_btn = "disabled";
              } else if ($tampil->approved == 2) {
                $approved = "Disetujui";
                $delete_btn = "disabled";
              }

              $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,$this->format->indo($tampil->omset_standart),$this->format->indo($tampil->bonus_standart),$this->format->indo($tampil->omset_real),$this->format->indo($tampil->bonus_real),$this->format->indo($tampil->total_diterima),$this->format->indo($tampil->total_kembali),$approved,$tampil->keterangan,
                '<a href="'.base_url('BonusBaru/'.$tampil->id_cabang.'/'.$bln.'/'.$thn.'/detailRekap').'">
                <span class="label label-warning">Detail</span>');
              $no++;
            }

            $tabel=$this->table->generate();
            echo $tabel;
        }
        else 
        {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>

      </div>

          <div class="form-group">
            <button type="submit" name="btn_aksi" value="excel" class="btn btn-success">
              Export Excel
            </button>
          </div>
      </form>
</div>

<script type="text/javascript">
</script>