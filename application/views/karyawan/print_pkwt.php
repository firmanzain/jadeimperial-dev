<div class="row">
	<div class="col-md-12">
		<h4>Draft Surat Untuk Karyawan : <?=$data->nama_ktp?></h4>		
		<hr>
		<div class="form-group">
		<textarea name="isi" class="ckeditor">
				<!--<html>
				<head>
					<title></title>
				</head>
				<body>
				<p style="text-align: center;"><span style="font-size:18px;"><u><strong>PERJANJIAN KERJA WAKTU TERTENTU</strong></u></span></p>

				<p style="text-align: center;"><span style="font-size:18px;"><strong>NO. <?=$id_kontrak?>/<?=$this->format->bulan(date('m',strtotime($data->tanggal_masuk)))?>/CRN ~ WTR/SDM/PKWT/<?=date('Y',strtotime($data->tanggal_masuk))?></strong></span></p>

				<p style="text-align: center;">&nbsp;</p>

				<p>Yang bertanda tangan di bawah ini :</p>

				<p style="margin-left: 40px;">&nbsp;I.&nbsp; Nama&nbsp;&nbsp;&nbsp; :&nbsp;</p>

				<p style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;&nbsp; Jabatan&nbsp; : Management Representative</p>

				<p style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;&nbsp; Dalam hal ini bertindak selaku kuasa dari kuasa perusahaan PT. CITRA RASA NINUSA Selanjutnya cukup disebut sebagai Pihak Pertama</p>

				<p style="margin-left: 40px;">II. Nama&nbsp;&nbsp; : <?=$data->nama_ktp?></p>

				<p style="margin-left: 40px;">&nbsp;&nbsp;&nbsp; Alamat&nbsp; : <?=$data->alamat_ktp?></p>

				<p style="margin-left: 40px;">&nbsp;&nbsp;&nbsp; Selanjutnya cukup disebut sebagai Pihak Kedua</p>

				<p>Sesuai dengan surat lamaran tanggal 25 Januari 2016 pada hari ini, para pihak dalam kedudukan masing-masing telah sepakat untuk mengikatkan diri dalam perjanjian kerja dan menerangkan hal-hal sebagai berikut :</p>

				<p>1. berdasarkan permohonan kerja Pihak Kedua yang menyatakan bersedia untuk menjadi karyawan waktu tertentu di PT. CITRA RASA NINUSA</p>

				<p>2. bahwa Pihak Kedua telah mengetahui dan memahami sistem kerja yang telah ditetapkan dan secara sadar tanpa paksaan dari pihak manapun, Pihak Kedua bersedia dan sanggup mengikatkan diri dengan Pihak Pertama.</p>

				<p>Adapun ketentuan perjanjian kerja untuk waktu tertentu yaitu :</p>

				<p style="text-align: center;"><strong>Pasal 1</strong></p>

				<p>Pihak Pertama memberikan lapangan kerja kepada Pihak Kedua sebagai berikut :</p>

				<p>1. Jabatan : <?=preg_replace('/[0-9]+/', '', $data->jabatan);?></p>

				<p>2. Periode Kerja : <?=$this->format->TanggalIndo($data->tanggal_masuk)?> s/d <?=$this->format->TanggalIndo($data->tanggal_resign)?></p>

				<p>3. Gaji : <?=$this->format->indo($data->gaji_pokok)?>,- / Bulan</p>

				<p>4. Tunjangan Jabatan : <?=$this->format->indo($data->tunjangan_jabatan)?>,- / Bulan</p>

				<p>5. Fasilitas : Makan , BPJS</p>

				<p>Pihak Kedua bersedia menerima pekerjaan yang diberikan oleh Pihak Pertama dan sanggup melaksanakan pekerjaan tersebut dengan sebaik-baiknya sesuai dengan standar dan ketentuan yang telah ditetapkan oleh Pihak Pertama.</p>

				<p style="text-align: center;"><strong>Pasal 2</strong></p>

				<p>1. Pihak Pertama berhak memberlakukan peraturan perusahaan dan ketentuan lainnya yang menyangkut hubungan kerja baik tertulis maupun tidak tertulis terhadap Pihak Kedua dan Pihak Kedua sanggup serta bersedia untuk mentaatinya,</p>

				<p>2. Dalam hal Pihak Kedua melanggar ketentuan mengenai Standar Operation Procedure, tata tertib, disiplin kerja atau melanggar ketentuan perundang-undangan yang berlaku, maka Pihak Pertama dapat memberikan sanksi baik berupa surat peringatan maupun pemutusan hubungan kerja,</p>

				<p>3. Pihak Pertama dapat melakukan pemotongan upah kepada Pihak Kedua, jika Pihak Kedua tidak masuk kerja tanpa keterangan yang sah atau yang dapat dibenarkan oleh Pihak Pertama.</p>

				<p style="text-align: center;"><strong>Pasal 3</strong></p>

				<p>Pihak Pertama berhak untuk melakukan mutasi dan demosi di dalam / di luar lokasi perusahaan, sepanjang tempat kerja tersebut adalah milik atau hak pakai atau hak sewa pengusaha dengan didasarkan atas kebutuhan dan/atau penilaian hasil kerja serta konduite Pihak Kedua yang pelaksanannya disesuaikan dengan ketentuan perusahaan yang berlaku.</p>

				<p style="text-align: center;"><strong>Pasal 4 </strong></p>

				<p>Pihak Kedua sanggup dan bersedia, apabila di kemudian hari Pihak Kedua tidak memenuhi standar dan melanggar ketentuan yang telah ditetapkan Pihak Pertama, maka Pihak Kedua sanggup dan bersedia mengakhiri hubungan kerja dan Pihak Pertama berhak mengakhiri perjanjian kerja waktu tertentu ini secara sepihak. Dalam hal ini, Pihak Pertama tidak mempunyai kewajiban untuk memberikan pesangon / ganti rugi dan syarat apapun kepada Pihak Kedua.</p>

				<p style="text-align: center;"><strong>Pasal 5 </strong></p>

				<p>Pihak Kedua tidak akan menuntut upah dan lain-lain, termasuk kebijaksanaan lain dari Pihak Pertama, apabila Pihak Pertama memberikan kebijaksanaan lain kepada karyawan yang berstatus tetap/karyawan untuk waktu tidak tertentu.</p>

				<p style="text-align: center;"><strong>Pasal 6 </strong></p>

				<p>Apabila sampai batas akhir berlakunya perjanjian kerja ini Pihak Pertama tidak melakukan permberitahuan untuk diperpanjang kepada Pihak Kedua, maka hubungan kerja ini berakhir demi hukum sesuai dengan berakhirnya waktu yang ditentukan dalam perjanjian kerja ini. Dalam hal ini Pihak Pertama tidak mempunyai kewajiban untuk memberikan pesangon/ganti rugi dan syarat apapun kepada Pihak Kedua.</p>

				<p style="text-align: center;"><strong>Pasal 7</strong></p>

				<p>Hal-hal yang tidak tercantum di dalam perjanjian kerja untuk waktu tertentu ini, Pihak Kedua akan terikat pada Peraturan Perusahaan, Standar Operation Procedure serta peraturan yang berlaku.</p>

				<p style="text-align: center;"><strong>Pasal 8</strong></p>

				<p>Apabila terjadi kesalahpahaman atau perselisihan antara Pihak Pertama dengan Pihak Kedua, akan diselesaikan secara musyawarah dengan itikad baik.</p>

				<p style="text-align: center;"><strong>Pasal 9</strong></p>

				<p>Pihak Pertama dan Pihak Kedua membenarkan bahwa kedua pihak telah membaca dan mengetahui isi perjanjian ini dengan baik dan kedua pihak menyetujui dan menyadari secara penuh akan hak dan kewajiban masing-masing. Apabila perselisihan tidak dapat diselesaikan dengan musyawarah, maka kedua pihak masing-masing memilih tempat kediaman hukum di kantor Departeman Tenaga Kerja setempat.</p>

				<p style="text-align: center;"><strong>Pasal 10</strong></p>

				<p>Perjanjian kerja ini dibuat dan ditandatangani oleh kedua belah pihak dalam keadaan sadar dan tanpa paksaan dari siapapun juga, dan berlaku sejak tanggal mulai dipekerjakannya Pihak Kedua sampai dengan tanggal berakhirnya perjanjian kerja ini.</p>

				<p>&nbsp;</p>

				<p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>

				<table border="0" cellpadding="1" cellspacing="1" height="28" width="1194">
					<tbody>
						<tr>
							<td>
							<p style="text-align: center;">Pihak Pertama</p>

							<p style="text-align: center;">&nbsp;</p>

							<p style="text-align: center;">()</p>

							<p style="text-align: center;">&nbsp;</p>
							</td>
							<td>
							<p style="text-align: center;">Pihak Kedua</p>

							<p style="text-align: center;">&nbsp;</p>

							<p style="text-align: center;">(<?=$data->nama_ktp?>)</p>
							</td>
						</tr>
					</tbody>
				</table>
				</body>
				</html>-->
			</textarea>
		</div>
		<!--<div class="form-group">
			<h4>PKWt Addendum</h4>
			<textarea name="adendum" class="ckeditor">
				<html>
				<head>
					<title></title>
				</head>
				<body>
				<table border="0" cellpadding="0" cellspacing="0" height="945" style="border-collapse: collapse;" width="1206">
					<colgroup>
						<col style="mso-width-source:userset;mso-width-alt:1718;width:35pt" width="47" />
						<col span="7" style="width:48pt" width="64" />
						<col style="mso-width-source:userset;mso-width-alt:2816;width:58pt" width="77" />
						<col style="width:48pt" width="64" />
					</colgroup>
					<tbody>
						<tr height="27" style="height:20.25pt">
							<td class="xl72" colspan="10" height="27" style="height: 20.25pt; width: 477pt; text-align: center;" width="636"><strong>ADDENDUM</strong></td>
						</tr>
						<tr height="22" style="mso-height-source:userset;height:16.5pt">
							<td class="xl73" colspan="10" height="22" style="height: 16.5pt; text-align: center;">NO :<span style="mso-spacerun:yes">&nbsp; </span><?=$id_kontrak?>/<?=$this->format->bulan(date('m',strtotime($data->tanggal_masuk)))?>/CRN ~ CK/SDM/PKWT/<?=date('Y',strtotime($data->tanggal_masuk))?></td>
						</tr>
						<tr height="16" style="mso-height-source:userset;height:12.0pt">
							<td class="xl65" height="16" style="height:12.0pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl66" height="20" style="height:15.0pt">I.</td>
							<td class="xl70" colspan="2">Nama</td>
							<td class="xl70" colspan="6">:<span style="mso-spacerun:yes">&nbsp; </span>RINANINGSIH GUNADI</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl70" colspan="2">Jabatan</td>
							<td class="xl70" colspan="6">:<span style="mso-spacerun:yes">&nbsp; </span>Management Representative</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl67" colspan="9" style="mso-ignore:colspan">Dalam hal ini bertindak selaku kuasa dari kuasa perusahaan PT. CITRA RASA NINUSA</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl70" colspan="8">Selanjutnya cukup disebut sebagai Pihak Pertama</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="10" style="mso-height-source:userset;height:7.5pt">
							<td class="xl66" height="10" style="height:7.5pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl66" height="20" style="height:15.0pt">II.</td>
							<td class="xl70" colspan="2">Nama</td>
							<td class="xl70" colspan="6">:<span style="mso-spacerun:yes">&nbsp; </span><?=$data->nama_ktp?></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl70" colspan="2">Alamat<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td class="xl67" colspan="6" style="mso-ignore:colspan">:<span style="mso-spacerun:yes">&nbsp; </span><?=$data->alamat_ktp?></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>Selanjutnya cukup disebut sebagai Pihak Kedua</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="10" style="mso-height-source:userset;height:7.5pt">
							<td class="xl66" height="10" style="height:7.5pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>Pada hari ini, para pihak dalam kedudukan masing-masing telah sepakat untuk mengikatkan diri</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>dalam perjanjian kerja dan menerangkan hal-hal sebagai berikut :</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">1.&nbsp;Berdasarkan permohonan kerja Pihak Kedua yang menyatakan bersedia untuk menjadi<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>karyawan waktu tertentu di PT. CITRA RASA NINUSA</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl67" colspan="10" height="20" style="height:15.0pt;mso-ignore:colspan">2.&nbsp;Bahwa Pihak Kedua telah mengetahui dan memahami sistem kerja yang telah ditetapkan dan secara<span style="mso-spacerun:yes">&nbsp;</span></td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl67" colspan="10" height="20" style="height:15.0pt;mso-ignore:colspan"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>sadar tanpa paksaan dari pihak manapun, Pihak Kedua bersedia dan sanggup mengikatkan diri<span style="mso-spacerun:yes">&nbsp;</span></td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>dengan Pihak Pertama.</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>Adapun isi addendum ini adalah :</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="7" style="mso-height-source:userset;height:5.25pt">
							<td class="xl68" height="7" style="height:5.25pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="19" style="mso-height-source:userset;height:14.25pt">
							<td class="xl71" colspan="9" height="19" style="height: 14.25pt; text-align: center;">Pasal 1</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">Pihak Pertama memberikan lapangan kerja kepada Pihak Kedua sebagai berikut :</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="5" height="20" style="height:15.0pt">1.<span style="mso-spacerun:yes">&nbsp; </span>Jabatan<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td class="xl70" colspan="4">: <font class="font5"><span style="mso-spacerun:yes">&nbsp;</span><?=$data->jabatan?></font></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="5" height="20" style="height:15.0pt">2.<span style="mso-spacerun:yes">&nbsp; </span>Periode Kerja<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td class="xl70" colspan="4">:<span style="mso-spacerun:yes">&nbsp; </span><?=$this->format->TanggalIndo($data->tanggal_masuk)?> s/d <?=$this->format->TanggalIndo($data->tanggal_resign)?></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="5" height="20" style="height:15.0pt">3.<span style="mso-spacerun:yes">&nbsp; </span>Gaji<span style="mso-spacerun:yes">&nbsp;&nbsp;</span></td>
							<td class="xl70" colspan="4">:<span style="mso-spacerun:yes">&nbsp; </span><?=$this->format->indo($data->gaji_pokok)?>,- / Bulan</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="5" height="20" style="height:15.0pt">4.<span style="mso-spacerun:yes">&nbsp; </span>Tunjangan Jabatan<span style="mso-spacerun:yes">&nbsp;&nbsp;</span></td>
							<td class="xl70" colspan="4">:<span style="mso-spacerun:yes">&nbsp; </span><?=$this->format->indo($data->tunjangan_jabatan)?>,- / Bulan</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="5" height="20" style="height:15.0pt">5.<span style="mso-spacerun:yes">&nbsp; </span>Fasilitas</td>
							<td class="xl70" colspan="5">:<span style="mso-spacerun:yes">&nbsp; </span>Makan, BPJS</td>
						</tr>
						<tr height="11" style="mso-height-source:userset;height:8.25pt">
							<td class="xl66" height="11" style="height:8.25pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">Pihak Kedua bersedia menerima pekerjaan yang diberikan oleh Pihak Pertama dan sanggup<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">melaksanakan pekerjaan tersebut dengan sebaik-baiknya sesuai dengan<span style="mso-spacerun:yes">&nbsp; </span>standar dan ketentuan<span style="mso-spacerun:yes">&nbsp;</span></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">yang telah ditetapkan oleh Pihak Pertama.</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="9" style="mso-height-source:userset;height:6.75pt">
							<td class="xl66" height="9" style="height:6.75pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">Demikian Addendum ini dibuat sebagai revisi atas perubahan Periode Kerja.</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="10" style="mso-height-source:userset;height:7.5pt">
							<td class="xl66" height="10" style="height:7.5pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl70" colspan="9" height="20" style="height:15.0pt">Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></td>
							<td>&nbsp;</td>
						</tr>
						<tr height="15" style="mso-height-source:userset;height:11.25pt">
							<td class="xl66" height="15" style="height:11.25pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl67" height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl68" colspan="2">Pihak Pertama</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="xl68" colspan="3">Pihak Kedua</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl69" height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl69">&nbsp;</td>
							<td class="xl69">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="xl69">&nbsp;</td>
							<td class="xl69">&nbsp;</td>
							<td class="xl69">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl66" height="20" style="height:15.0pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl66" height="20" style="height:15.0pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="33" style="mso-height-source:userset;height:24.75pt">
							<td class="xl66" height="33" style="height:24.75pt">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr height="20" style="height:15.0pt">
							<td class="xl67" height="20" style="height:15.0pt">&nbsp;</td>
							<td class="xl68" colspan="2">Rinaningsih Gunadi</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="xl68" colspan="3"><?=$data->nama_ktp?></td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
				</body>
				</html>
			</textarea>
		</div>-->
	</div>
</div>