<div class="col-md-12">
    <h3>Data Detail Approval Bonus Karyawan Plant </h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
    <form method="post" id="form_data" action="<?=base_url()?>Aprov/aprov_bonus">
      <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
      <div class="table-responsive" style="overflow: scroll;">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
          $cek_data=$this->db->where('month(tanggal_bonus)',date('m'))->where('nik',$tampil->nik_kar)->get('tab_bonus_karyawan')->num_rows();
          if ($cek_data<1) {
              $bonus_grade=$tampil->nilai_grade*$tampil->prosen_point;
              $bonus_senioritas=round($tampil->total_senioritas,0)*$tampil->prosen_point;
              $bonus_nominal=$tampil->total_nominal;
              $bonus_persentase=$tampil->total_persentase/100*$tampil->omset;
              if ($tampil->prota==1) {
                  $bonus_prota=$tampil->bonus_prota;
              }else{
                $bonus_prota=0;
              }
              $total_bonus=$bonus_grade+$bonus_prota+$bonus_persentase+$bonus_nominal+$bonus_senioritas;
              $total_grade+=$bonus_grade;
              $total_senioritas+=$bonus_senioritas;
              $total_nominal+=$bonus_nominal;
              $total_persen+=$bonus_persentase;
              $total_prota+=$bonus_prota;
              $jml_bonus+=$total_bonus;
              $data=array(
                          "nik"=>$tampil->nik_kar,
                          "nominal"  => $bonus_nominal,
                          "senioritas" => $bonus_senioritas,
                          "grade" => $bonus_grade,
                          "persentase" => $bonus_persentase,
                          "prota" => $bonus_prota,
                          "tanggal_bonus" => date('Y-m-d'),
                          "approved" => "Ya",
                          "keterangan" => $this->input->post('keterangan'),
                          "include_pph" => $tampil->include_pph
                          );
              $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.implode(":", $data).'>',$no,$tampil->nik_kar,$tampil->nama,$tampil->jabatan,$this->format->indo($bonus_grade),$this->format->indo($bonus_senioritas),$this->format->indo($bonus_prota),$this->format->indo($bonus_persentase),$this->format->indo($bonus_nominal),$this->format->indo($total_bonus),'<button class="label label-danger" type="button" onclick=disapro("'.implode(':', $data).'",this)> Tidak Setuju</button>');
          }
          $no++;
        }
        $this->table->add_row('',array('data'=>'<b>Total</b>','colspan'=>'4'),$this->format->indo($total_grade),$this->format->indo($total_senioritas),$this->format->indo($total_prota),$this->format->indo($total_persen),$this->format->indo($total_nominal),$this->format->indo($jml_bonus),'');
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
      </div>
      <div class="form-group">
      <button type="submit" class="btn btn-primary">
        Aprove
      </button>
      <button type="submit" class="btn btn-warning" onclick="window.history.go(-1); return false;; return false;">
        Back
      </button>
    </div>
    </form>
</div>
<div class="col-md-12">
        <div id="flash"></div>
        <div id="dis" hidden>
            <div class="form-group">
                <label>Alasan Tidak Disetujui</label>
                <input type="hidden" name="data" id="data">
                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default" onclick="prosesDisapro(this.value)" id="send">Send</button>
                <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
            </div>
        </div>
      </div>
<script type="text/javascript">
  function disapro(x,y) {
    $('#dis').attr('hidden',false);
    $('#send').attr('value',y.parentNode.parentNode.rowIndex);
    $('#data').attr('value',x);
    $('#keterangan').attr('value','');
    
  }
  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var isi=$('#data').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/aprov_bonus",
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
        });
  }
</script>