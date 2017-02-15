<div class="row">
  <div class="col-md-5">
  <h4>Rekapitulasi Saldo DP / Cuti Karyawan</h4>
  <hr>
        <?=$this->session->flashdata('pesan');?>
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
        $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,anchor('master-dp/'.$tampil->id_cabang.'/detail_rekap','<span class="label label-info">Lihat Rekap</span>'));
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