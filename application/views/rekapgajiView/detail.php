<form>
<h3>"Detail Rekap Gaji"</h3><br>
<?php 
		$cabang = $this->db->get('tab_cabang')->result();
			foreach($cabang as $hasil){
				$m=$this->db->where('cabang',$hasil->cabang);
				$k = $this->db->get('tab_karyawan');
			$m=$this->db->where('cabang',$hasil->cabang);
			$this->db->select_sum('gaji_pokok');
			$karyawan = $this->db->get('tab_karyawan')->row();
				
			?>
	<table class="table table-bordered">
			<h4><?=$hasil->cabang;?></h4>
		<tr>
		<th bgcolor="seablue">No.</th>
		<th bgcolor="yellow">NIK</th>
		<th bgcolor="orange">Nama Sesuai KTP</th>
		<th bgcolor="whitebrown">Jabatan</th>
		<th bgcolor="yellowgreen">Upah Jamsostek</th>
		<th bgcolor="brown">Gaji Pokok</th>
		<th bgcolor="gray">Extra</th>
		<th bgcolor="silver">DP Cuti</th>
		<th bgcolor="salmon">JHT(2%)</th>
		<th bgcolor="blueyellow">JPK(1%)</th>
		<th bgcolor="grape">PPh 21</th>
		<th bgcolor="crime">Gaji Transfer</th>
		<th>Rekap Gaji</th>
		</tr>
		<?php $no=1;
		$ca= $this->db->where('cabang',$hasil->cabang);
		$ka = $this->db->get('tab_karyawan')->result();
			foreach($ka as $hasil){
		$t= $this->db->where('nik',$hasil->nik);
		$tu = $this->db->get('tab_tunjangan_karyawan')->result();
			if($hasil->status_pajak == 'TK'){
				$pa = '3000000';
			}if($hasil->status_pajak == 'K/0'){
				$pa = '3250000';
			}if($hasil->status_pajak == 'K/1'){
				$pa = '3500000';
			}if($hasil->status_pajak == 'K/2'){
				$pa = '3750000';
			}if($hasil->status_pajak == 'K/3'){
				$pa = '4000000';
			}
				$a = '60900';
				$b = '30450';
				$c = $hasil->gaji_pokok;
				$d = $hasil->gaji_bpjs;
			$total = $c - ($a + $b);?>
		<tr>
		<td><?=$no++?></td>
		<td><?=$hasil->nik?></td>
		<td><?=$hasil->nama_ktp?></td>
		<td><?=$hasil->jabatan?></td>
		<td><?=$hasil->gaji_bpjs?></td>
		<td><?=$hasil->gaji_pokok?></td>
		<td></td>
		<td></td>
		<td><?=$a?></td>
		<td><?=$b?></td>
		<td><?php foreach($tu as $hasilt){
				$g = $hasil->gaji_pokok + $hasilt->tarif;
				$ga = $d * '0,04';$gb = $d * '0,037';
				$gaj = $g + $ga + $gb;
				$bi = $gaj * '0,05'; 
				$jht = $hasil->gaji_bpjs * '0,02';
				$pkp = $gaj + $bi + $pkp + $jht;				
				
			} ?></td>
		<td><?=$total?></td>
		<td><?=anchor('RekapgajiController/cetakrekapgaji/'.$hasil->nik.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div>Print</span>');?></td>
		</tr>
	<?php } } ?>
	</table>
		
<button type="submit" style="margin-left:40%;margin-top:5%;width:20%;height:40%;" class="btn btn-primary" name="submit">Kembali</button>
</form>