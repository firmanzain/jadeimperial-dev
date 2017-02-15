<div class="col-md-12">
    <h3>Data Approval Bonus Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <div class="table-responsive" style="overflow: scroll;">
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>Aprov/aprov_bonus">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
            if ($tampil->approved!="Ya") {
              $data2 = $this->bonus->detail($tampil->cabang,$bln,$thn);
              // print_r($this->db->last_query());

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

              $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$tampil->id_omset.'"><input type=checkbox name=cb_data[] id="cb_data'.$tampil->id_omset.'" value='.$tampil->id_omset.' onclick="set_id('.$tampil->id_omset.')">',$tampil->nama_cabang,$this->format->indo($tampil->omset),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($sum_total_bonus),$this->format->indo($sum_total_bulat),$this->format->indo($sum_total_bonus-$sum_total_bulat),$this->format->indo($sum_total_bonus2),$this->format->indo($sum_total_kembali),$tampil->approved,'<button class="label label-danger" type="button" onclick=disapro('.$tampil->id_omset.')> Tidak Setuju</button>');
              $no++;
            }
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">
          Aprove Selected
        </button>
        <?php if ($this->session->userdata('id_level') == 1) { ?>
        <button type="button" class="btn btn-danger" onclick="prosesCancel()">
          Cancel Approve
        </button>
        <?php } ?>
      </div>
      </form>
      </div>
</div>

<div class="col-md-12">
  <div id="flash"></div>
  <div id="dis" hidden>
    <div class="form-group">
      <label>Alasan Tidak Disetujui</label>
      <input type="hidden" name="id" id="id">
      <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-default" onclick="prosesDisapro()" id="send">Send</button>
      <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  function set_id(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      document.getElementById("iddet"+id).value = id;
    }
  }
  function disapro(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      $('#dis').attr('hidden',false);
      document.getElementById("id").value = id; 
    }
  }
  function prosesDisapro() {
    var id = $('#id').val();
    var ket = $('#keterangan').val();
    $.ajax({
      type: "POST",
      url : "<?php echo base_url(); ?>Aprov/aprov_bonus_v2",
      data : "id="+id+"&keterangan="+ket+"",
      success: function(data){
        location.reload();
      }
    });
  }
  function prosesCancel() {
    var bln = document.getElementsByName('bln')[0].value;
    var thn = document.getElementsByName('tahun')[0].value;
    $.ajax({
      type: "POST",
      url : "<?php echo base_url(); ?>Aprov/cancelaprov_bonus",
      data : "bln="+bln+"&thn="+thn,
      success: function(data){
        alert("Approve Telah Dibatalkan.");
        location.reload();
      }
    });
  }
</script>