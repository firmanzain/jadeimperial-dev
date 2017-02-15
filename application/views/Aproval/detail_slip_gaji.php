<div class="col-md-12">
    <h4>Detail Gaji Karyawan Plant <?=$cabang?></h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
    <form method="post" action="<?=base_url()?>Aprov/gajiKaryawan">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        $cek_data=$this->db->where('month(tanggal_gaji)',date('m'))->where('nik',$tampil->nik_karyawan)->get('tab_gaji_karyawan')->num_rows();
        if ($cek_data<1) {
            $kalender=CAL_GREGORIAN;
            $bulan = date('m');
            $tahun= date('Y');
            $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
            $hitungan=$this->model_gaji->rincian_gaji_karyawan($tampil->nik_karyawan,$jml_hari);
            $jpk=($tampil->gaji_bpjs*$hitungan['jpk'] != 0)? ($tampil->gaji_bpjs*$hitungan['jpk']/100):0;
            $jht=($tampil->gaji_bpjs*$hitungan['jht'] != 0)? ($tampil->gaji_bpjs*$hitungan['jht']/100):0;
            $gaji_bersih=($tampil->gaji_pokok+$hitungan['ekstra'])-$tampil->jml_pph-($jpk+$jht)-$hitungan['cuti']-$hitungan['pinjaman'];
            $array_gaji=array('nik'=>$tampil->nik_karyawan,
                               'gaji_ekstra'=>$hitungan['ekstra'],
                               'pph21'=>$tampil->jumlah_pph,
                               'pinjaman'=>$hitungan['pinjaman'],
                               'tunjangan_jabatan'=>$tampil->tunjangan_jabatan,
                               'potongan_cuti'=>$hitungan['cuti'],
                               'bea_jht'=>$jht,
                               'bea_jpk'=>$jpk,
                               'gaji_karyawan'=>$gaji_bersih,
                               'link'=>base64_encode(current_url())
                               );
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.base64_encode(implode(':', $array_gaji)).'>',$no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$this->format->indo($tampil->gaji_bpjs),$this->format->indo($tampil->gaji_pokok),$this->format->indo($hitungan['ekstra']),$this->format->indo($hitungan['pinjaman']),$this->format->indo($tampil->jml_pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($hitungan['cuti']),$this->format->indo($gaji_bersih),"<button class='label label-danger' type='button' onclick=disapro('".base64_encode(implode(':', $array_gaji))."',this)> Tidak Setuju</button>");
            $no++;
        }
      }
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
      <button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">
        Back
      </button>
    </div>
    </form>
    <div class="col-md-12">
        <div id="flash"></div>
        <div id="dis">
            <div class="form-group">
                <label>Alasan Tidak Disetujui</label>
                <input type="hidden" name="nik" id="nik">
                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default" onclick="prosesDisapro(this.value)" id="send">Send</button>
                <button class="btn btn-danger" type="button" id="batal">Cancel</button>
            </div>
        </div>
      </div>
</div>
<script type="text/javascript">
  $('#dis').hide();
  function disapro(x,y) {
    $('#dis').slideDown(1000);
    $('#send').attr('value',y.parentNode.parentNode.rowIndex);
    $('#nik').attr('value',x);
    $('#keterangan').attr('value','');
    $('#keterangan').focus();
    
  }
  $('#batal').click(function(){
    $('#nik').val('');
    $('#keterangan').val('');
    $('#dis').slideUp(1000);
  })
  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var nik=$('#nik').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/gajiKaryawan",
            data : "nik="+nik+"&keterangan="+ket+"",
            beforeSend: function(msg){$('#flash').show();$("#flash").html('Please wait...');$('#dis').hide();},
            success: function(msg){
              $('#flash').hide();
              if (msg=="sukses") {
                  tabel.deleteRow(a);
              } else {
                  $('#dis').show();
              }
            }
        });
  }
</script>