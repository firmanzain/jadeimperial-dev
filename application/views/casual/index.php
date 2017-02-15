<div class="col-md-12">
    <h4>Data Casual Ekstra Karyawan<br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
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
            <div class="col-sm-6 text-left">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>CasualEkstra/hapus">
        <div class="table-responsive" style="overflow: scroll;">
            <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
            if ($tampil->jns_ekstra==1) {
                $jenis = "Jam";
            } else if ($tampil->jns_ekstra==2) {
                $jenis = "Hari";
            } 

            if ($tampil->approved=="0") {
              $app = "Belum";
              $cetak = "hidden";
            } else if ($tampil->approved=="1") {
              $app = "Tidak";
              $cetak = "hidden";
            } else if ($tampil->approved=="2") {
              $cetak = " ";
              $app = "Setuju";
            }
        $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_casual.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->kepala_department,$tampil->hrd,$tampil->cabang,$this->format->TanggalIndo($tampil->tgl_ekstra),$tampil->lama." ".$jenis,$this->format->indo($tampil->total),$app,$tampil->keterangan,$tampil->keterangan_ekstra);
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
        <?=anchor('CasualEkstra/create','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" name="tombol" onClick="return warning();">Hapus Data</button>
        </div>
      </form>
</div>