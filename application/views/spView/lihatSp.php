<h3>Data Peringatan Karyawan</h3>
<div class="panel panel-default">
    <div class="panel-body">
          <form name="form_data" method="post" id="form_hasil" action="">
            <div class="table-responsive" id="show">
              <?php
                 if($data==true){
                  $no=1;
                  foreach ($data as $tampil){
					$k=$this->db->where('nik',$tampil->nik);
					$k1=$this->db->get('tab_karyawan')->row();
					$p=$this->db->where('nik',$tampil->nik);
					$p1=$this->db->get('tab_sp');
					$sp=$this->db->where('nik',$tampil->nik);
					$sp1=$this->db->get('tab_sp')->row();
					foreach($sp1 as $sp){
						
					}
					
                  $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->nik,$no,$k1->nama_ktp,$tampil->peringatan,$tampil->tanggal_sp,$tampil->isi_sp,anchor('SpController/cetaksp/'.$tampil->id_sp.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div>Print</span>'));
                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>data Tidak Ditemukan</div>";
                 }
              ?>
            </div>
    </div>
    <div class="panel-footer">
		<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Kembali</button>
        <!--<?=anchor('spController/lihatsp','Lihat sp',['class' => 'btn btn-primary'])?>
        <button class="btn btn-info" type="button" onClick="importdata()">Import data</button>
        <button class="btn btn-danger delete" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus data</button>-->
    </form>
  </div>
</div>