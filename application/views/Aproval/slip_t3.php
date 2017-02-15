<div class="col-md-12">
		<h3>DATA T3 Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>Aprov/aprov_t3">
        <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
              /*$cek=$this->db->where('nik',$tampil->nik)
                            ->where('month(tanggal)',date('m'))
                            ->get('tab_t3')
                            ->num_rows();
              if ($cek<1) {
                  $total=$tampil->jml_hadir*$tampil->s_tarif;
                  $data=array(
                              "nik" => $tampil->nik,
                              "jml_hadir" => $tampil->jml_hadir,
                              "total_t3" => $total,
                              "tanggal" => date('Y-m-d'),
                              );*/
                  //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.implode(":", $data).'>',$no,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$this->format->indo($tampil->s_tarif),$tampil->jml_hadir,$this->format->indo($total),'<button class="label label-danger" type="button" onclick=disapro("'.implode(':', $data).'",this)> Tidak Setuju</button>');
                  if ($tampil->approved!="Ya") {

                    $this->table->add_row('
                                            <input type="hidden" name="iddet[]" id="iddet'.$tampil->id_real.'">
                                            <input type=checkbox name=cb_data[] id="cb_data'.$tampil->id_real.'" value='.$tampil->id_real.' onclick="set_id('.$tampil->id_real.')">',
                                            $tampil->nama_ktp,
                                            $tampil->jabatan,
                                            $tampil->cabang,
                                            $this->format->indo($tampil->tarif),
                                            $tampil->jml_hadir,
                                            $this->format->indo($tampil->total_t3),
                                            $this->format->indo(intval(($tampil->total_t3/1000))*1000),
                                            $tampil->approved,
                                            '<button class="label label-danger" type="button" onclick=disapro('.$tampil->id_real.')> Tidak Setuju</button>');
                    
                    $no++;
                  }
              //}
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">
            Aprove
          </button>
          <?php if ($this->session->userdata('id_level') == 1) { ?>
          <button type="button" class="btn btn-danger" onclick="prosesCancel()">
            Cancel Approve
          </button>
          <?php } ?>
        </div>
        </form>
  </div>
<div class="col-md-12">
        <div id="flash"></div>
        <div id="dis" hidden>
            <div class="form-group">
                <label>Alasan Tidak Disetujui</label>
                <input type="hidden" name="id" id="idtemp">
                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default" onclick="prosesDisapro()" id="send">Send</button>
                <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
            </div>
        </div>
      </div>
<script type="text/javascript">
  /*function disapro(x,y) {
    $('#dis').attr('hidden',false);
    $('#send').attr('value',y.parentNode.parentNode.rowIndex);
    $('#data').attr('value',x);
    $('#keterangan').attr('value','');
    
  }*/
  function set_id(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      document.getElementById("iddet"+id).value = id;
    }
  }
  function disapro(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      $('#dis').attr('hidden',false);
      document.getElementById("idtemp").value = id; 
    }
  }
  function prosesDisapro() {
    /*var tabel= document.getElementById('example-2');
    var isi=$('#data').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>aprov/aprov_t3",
            data : "data="+isi+"&keterangan="+ket+"",
            beforeSend: function(msg){$('#flash').attr('hidden',false);$("#flash").html('Please wait...');$('#dis').attr('hidden',true);},
            success: function(msg){
              if (msg=="sukses") {
                  $('#flash').attr('hidden',true);
                  tabel.deleteRow(a);
              } else {
                  $('#dis').attr('hidden',false);
                  $('#flash').attr('hidden',true);
              }
            }
        });*/
    var id = $('#idtemp').val();
    var ket = $('#keterangan').val();
    $.ajax({
      type: "POST",
      url : "<?php echo base_url(); ?>Aprov/aprov_t3_v2",
      data : "id="+id+"&keterangan="+ket+"",
      /*beforeSend: function(msg){$('#flash').attr('hidden',false);$("#flash").html('Please wait...');$('#dis').attr('hidden',true);},*/
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
      url : "<?php echo base_url(); ?>Aprov/cancelaprov_t3",
      data : "bln="+bln+"&thn="+thn,
      success: function(data){
        alert("Approve Telah Dibatalkan.");
        location.reload();
      }
    });
  }
</script>