<div class="col-md-12">
    <h3>Data Detail Bonus Karyawan Plant <?=$cabang?> Bulan <?=$this->format->BulanIndo($bln)?></h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <div class="table-responsive" style="overflow: scroll;">
        <?php
        if($data==true){
        $no=1;
        $sum_bonus_standart = 0;
        $sum_bonus_real = 0;
        $sum_total_diterima = 0;
        $sum_total_kembali = 0;
        $sum_total_bulat_diterima = 0;

        foreach ($data->result() as $tampil){
          if ($tampil->nik!=NULL) {
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

          //SUM
          $sum_bonus_standart += $tampil->bonus_standart;
          $sum_bonus_real += $tampil->bonus_real;
          $sum_total_diterima += $tampil->total_diterima;
          $sum_total_kembali += $tampil->total_kembali;
          $sum_total_bulat_diterima += $tampil->total_bulat_diterima;

          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$this->format->indo($tampil->bonus_standart),$this->format->indo($tampil->bonus_real),$this->format->indo($tampil->total_diterima),$this->format->indo($tampil->total_kembali),$this->format->indo($tampil->total_bulat_diterima),$approved,$tampil->keterangan);
          $no++;
          }
        }
        $this->table->add_row('',array('data'=>'<b>Total</b>','colspan'=>'2'),$this->format->indo($sum_bonus_standart),$this->format->indo($sum_bonus_real),$this->format->indo($sum_total_diterima),$this->format->indo($sum_total_kembali),$this->format->indo($sum_total_bulat_diterima),'','');
        $tabel=$this->table->generate();
        echo $tabel;
        } else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
      </div>
</div>