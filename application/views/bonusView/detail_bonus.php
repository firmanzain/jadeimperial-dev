<div class="col-md-12">
    <h3>Data Detail Bonus Karyawan Plant <?=$cabang?> Bulan <?=$this->format->BulanIndo($bln)?></h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <div class="table-responsive" style="overflow: scroll;">
        <?php
        if($data==true){
        $no=1;
        $sum_total_point = 0;
        $sum_bonus_prosen = 0;
        $sum_bonus_nominal = 0;
        $sum_bonus_point = 0;
        $sum_bonus_prorata = 0;
        $sum_total_bonus = 0;
        $sum_total_bulat = 0;
        $sum_total_kembali = 0;
        $sum_total_bonus2 = 0;

        foreach ($data as $tampil){
          if ($tampil->nik_bonus!=NULL) {

          //SUM
          $sum_total_point += $tampil->total_point;
          $sum_bonus_prosen += $tampil->bonus_prosen;
          $sum_bonus_nominal += $tampil->bonus_nominal;
          $sum_bonus_point += $tampil->bonus_point;
          $sum_bonus_prorata += $tampil->bonus_prorata;
          $sum_total_bonus += $tampil->total_bonus;
          $sum_total_bulat += $tampil->total_bulat;
          $sum_total_kembali += $tampil->total_kembali;
          $sum_total_bonus2 += $tampil->total_diterima;

          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,/*$this->format->indo($bonus_grade)*/$tampil->grade,$tampil->point,$tampil->senioritas,$tampil->total_point,$this->format->indo($tampil->bonus_prosen),$this->format->indo($tampil->bonus_nominal),$this->format->indo($tampil->bonus_point),$this->format->indo($tampil->bonus_prorata),$this->format->indo($tampil->total_bonus),$this->format->indo($tampil->total_bulat),$this->format->indo($tampil->total_kembali),$this->format->indo($tampil->total_diterima));
          $no++;
          }
        }
        $this->table->add_row('',array('data'=>'<b>Total</b>','colspan'=>'6'),$sum_total_point,$this->format->indo($sum_bonus_prosen),$this->format->indo($sum_bonus_nominal),$this->format->indo($sum_bonus_point),$this->format->indo($sum_bonus_prorata),$this->format->indo($sum_total_bonus),$this->format->indo($sum_total_bulat),$this->format->indo($sum_total_kembali),$this->format->indo($sum_total_bonus2));
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
      </div>
</div>