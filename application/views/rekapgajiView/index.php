<form method="post" action="">
	<table class="table table-bordered">
		<tr>
		<td align="center" bgcolor="red"><?=date('M')?></td>
		</tr>
		<tr>
		<th bgcolor="seablue">Plant</th>
		<th bgcolor="yellow">Gaji</th>
		<th bgcolor="orange">Extra</th>
		<th bgcolor="whitebrown">DP Cuti</th>
		<th bgcolor="brown">JHT</th>
		<th bgcolor="gray">JPK</th>
		<th bgcolor="silver">PPh 21</th>
		<th bgcolor="gold">Gaji Diterima</th>
		</tr>
	<?php $cabang = $this->db->get('tab_cabang')->result();
						foreach($cabang as $hasil){
				$m=$this->db->where('cabang',$hasil->cabang);
				$k = $this->db->get('tab_karyawan');
			$m=$this->db->where('cabang',$hasil->cabang);
			$this->db->select_sum('gaji_pokok');
			$karyawan = $this->db->get('tab_karyawan')->row();
				$a = $k->num_rows * '60900';
				$b = $k->num_rows * '30450';
				$c = $karyawan->gaji_pokok;;
			$total = $c - ($a + $b);
			?>
		<tr>
		<td><?=$hasil->cabang?></td>
		<td><?=$karyawan->gaji_pokok?></td>
		<td></td>
		<td></td>
		<td><?=$a?></td>
		<td><?=$b?></td>
		<td></td>
		<td><?=$total?></td>
		</tr>
	<?php } ?>
	</table>
		
<button type="submit" style="margin-left:40%;margin-top:5%;width:20%;height:40%;" class="btn btn-primary" name="submit">Detail</button>
</form>