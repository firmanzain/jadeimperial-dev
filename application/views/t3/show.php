<div class="col-md-12">
		<h4>DATA T3 Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
      <button type="button" name="btn_aksi" value="Generate T3" class="btn btn-primary" onclick="generate_t3(<?=$bln?>,<?=$thn?>)">
        Generate T3
      </button>
    <hr>
    <?=$this->session->flashdata('pesan');?>
      <div class="table-responsive" style="overflow: scroll;">
        <?php
           if($data==true){ // jika data bulan lalu diketemukan

            $no=1;

            foreach ($data as $tampil){

              $pembulatan = intval(($tampil->total_t3/1000))*1000;
              $data=array(
                      "id" => $tampil->id,
                      "nik" => $tampil->nik,
                      "nama" => $tampil->nama_ktp,
                      "cabang" => $tampil->cabang,
                      "jabatan" => $tampil->jabatan,
                      "jml_hadir" => $tampil->jml_hadir,
                      "bulan " => $this->format->BulanIndo(date('m',strtotime($tampil->tanggal))).' '.date('Y',strtotime($tampil->tanggal)),
                      "tarif" => $this->format->indo($tampil->tarif),
                      "total" => $this->format->indo($pembulatan),
                      "tahun" => $tampil->tanggal
                      );

              if ($tampil->approved=='Ya') {
                $mati='';
              } else {
                // $mati="disabled";
                $mati='';
              }
            $this->table->add_row($no,
                                    $this->format->BulanIndo(date('m',strtotime($tampil->tanggal))),
                                    $tampil->nik,
                                    $tampil->nama_ktp,
                                    $tampil->jabatan,
                                    $tampil->cabang,
                                    $this->format->indo($tampil->tarif),
                                    $tampil->jml_hadir,
                                    $this->format->indo($tampil->total_t3),
                                    $this->format->indo($pembulatan),
                                    $tampil->approved,
                                    $tampil->keterangan,
                                    "<button onclick=cetak('".base64_encode(implode(':', $data))."') class='label label-success' $mati>Cetak Data</button>");
            //$this->table->add_row($no,$tampil['bulan'],$tampil['nik'],$tampil['nama'],$tampil['jabatan'],$tampil['cabang'],$tampil['tarif'],$tampil['hadir'],($tampil['tarif']*$tampil['hadir']),"Ya","Auto Generate","<button onclick=cetak('".base64_encode(implode(':', $data))."') class='label label-success'>Cetak Data</button>");
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
<script type="text/javascript">
  function cetak(a) {
    sUrl="<?=base_url()?>T3Controller/cetak/"+a+""; features = 'toolbar=no, left=350,top=100, ' + 
        'directories=no, status=no, menubar=no, ' + 
        'scrollbars=no, resizable=no';
        window.open(sUrl,"winChild",features);
  }

  function generate_t3(bln,thn) {
    $.ajax({
      type : "POST",
      url  : '<?php echo base_url();?>T3Controller/generate_t3/',
      data : 'bln='+bln+'&thn='+thn,
      dataType : "json",
      success:function(data){
        if(data.status=='200'){
          alert("Data telah digenerate.");
          location.reload();
        } else if(data.status=='204'){
          alert("Data telah digenerate ulang.");
          location.reload();
        }
      }
    });
  }
</script>