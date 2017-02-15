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
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>BonusBaru/approveData/2">
      <div class="table-responsive" style="overflow: scroll;">
      
        <?php
        if($data == true){
            $no=1;

            foreach ($data->result() as $tampil){
              if ($tampil->approved != 2) {
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

                $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$tampil->id_omset.'"><input type=checkbox name=cb_data[] id="cb_data'.$tampil->id_omset.'" value='.$tampil->id_omset.' onclick="set_id('.$tampil->id_omset.')">',$tampil->cabang,$tampil->jml_karyawan,$this->format->indo($tampil->omset_standart),$this->format->indo($tampil->bonus_standart),$this->format->indo($tampil->omset_real),$this->format->indo($tampil->bonus_real),$this->format->indo($tampil->total_diterima),$this->format->indo($tampil->total_kembali),$approved,$tampil->keterangan,'<button class="label label-danger" type="button" onclick=disapro('.$tampil->id_omset.')> Tidak Setuju</button>');
                $no++;
              }
            }

            $tabel=$this->table->generate();
            echo $tabel;
        }
        else 
        {
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

      </div>
      </form>
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
      url : "<?php echo base_url(); ?>BonusBaru/approveData/2",
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
      url : "<?php echo base_url(); ?>BonusBaru/cancelapproveData",
      data : "bln="+bln+"&thn="+thn,
      success: function(data){
        alert("Approve Telah Dibatalkan.");
        location.reload();
      }
    });
  }
</script>