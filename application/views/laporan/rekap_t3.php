<div class="col-md-12">
	<h3>Rekap Tunjangan T3 Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h3>
	<hr>
    <form class="form-horizontal" id="form-periode" method="POST">
        <div class="form-group row">
          <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
            <div class="col-sm-4">
              <div class="input-daterange input-group" id="date-picker1">
                  <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo $tgl1;?>" />
                  <span class="input-group-addon">s/d</span>
                  <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo $tgl2;?>" />
              </div>
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="cabang">
                    <option value="">All</option>
                    <?php
                        foreach ($cabang as $plant) {
                            echo "<option value='$plant->id_cabang'>$plant->cabang</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-4 text-left">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <form method="post" id="form_data" action="<?=base_url()?>T3Controller/cetakData" target="new">
        <div class="table-responsive" style="overflow: scroll; margin-top: 10px;">
            <input type="hidden" value="<?=$this->input->post('tgl1')?>" name="tanggal1">
            <input type="hidden" value="<?=$this->input->post('tgl2')?>" name="tanggal2">
            <input type="hidden" value="<?=$this->input->post('cabang')?>" name="cabang">
            <?=$this->session->flashdata('pesan');?>
                <?php
                   if($data==true){

                    $no=1;

                    foreach ($data as $tampil){
                    
                    if ($tampil->total_t3!=0&&$tampil->jml_hadir!=0) {

                        $tarifx = $this->format->indo($tampil->total_t3/$tampil->jml_hadir);

                    } else {
                        $tarifx = 0;
                    }

                    $this->table->add_row($no,
                        $this->format->TanggalIndo($tampil->tanggal),
                        $tampil->nik,$tampil->nama_ktp,
                        $tampil->jabatan,
                        $tampil->cabang,
                        $tampil->nama_rekening,
                        $tampil->no_rekening,
                        $this->format->indo($tampil->tarif),
                        $tampil->jml_hadir,
                        $this->format->indo($tampil->total_t3),
                        $this->format->indo(intval(($tampil->total_t3/1000))*1000),
                        $tampil->approved,
                        $tampil->keterangan);
                    $no++;
                    }
                    $tabel=$this->table->generate();
                    echo $tabel;
                   }
                   else // $data!=true ( data tidak ditemukan)
                   {
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
<script type="text/javascript">
  $( document ).ready(function() {
  });
</script>