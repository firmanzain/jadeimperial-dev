<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';

$route['jadwal/add'] = 'JamKerjaController/create';
$route['jadwal'] = 'JamKerjaController/index';
$route['jadwal/(:any)/edit'] = 'JamKerjaController/edit/$1';
$route['jadwal/hapus'] = 'JamKerjaController/hapus';
$route['jadwal/get_all'] = 'JamKerjaController/get_all';
$route['jadwal/import'] = 'JamKerjaController/import_data';

$route['liburan/add'] = 'LiburController/create';
$route['liburan'] = 'LiburController/index';
$route['liburan/(:any)/edit'] = 'LiburController/edit/$1';
$route['liburan/hapus'] = 'LiburController/hapus';
$route['liburan/import'] = 'LiburController/import_data';

$route['perizinan/add'] = 'IzinController/create';
$route['perizinan'] = 'IzinController/index';
$route['perizinan/(:any)/edit'] = 'IzinController/edit/$1';
$route['perizinan/hapus'] = 'IzinController/hapus';

//administrasi
$route['mutasi'] = 'MutasiController/index';
$route['mutasi/see'] = 'MutasiController/lihatmutasi';
$route['mutasi/print'] = 'MutasiController/cetakmutasi';

$route['peringatan'] = 'SpController/index';
$route['peringatan/print'] = 'SpController/cetaksp';
$route['sp/add'] = 'SpController/create';
$route['sp/hapus'] = 'SpController/hapus';

$route['pengangkatan'] = 'PengangkatanController/index';
$route['pengangkatan/see'] = 'PengangkatanController/lihatpengangkatan';
$route['pengangkatan/print'] = 'PengangkatanController/cetakpengangkatan';
$route['memo'] = 'MemoController/index';

$route['cuti/add'] = 'CutiController/create';
$route['cuti'] = 'CutiController/index';
$route['cuti/(:any)/edit'] = 'CutiController/edit/$1';
$route['cuti/hapus'] = 'CutiController/hapus';

$route['user/level/add'] = 'User/create_level';
$route['user/level'] = 'User/user_level';
$route['user/level/(:any)/edit'] = 'User/edit_level/$1';
$route['user/(:any)/edit'] = 'User/edit/$1';
$route['user/level/(:any)/privillage'] = 'User/all_menu/$1';
$route['user/level/(:any)/notifikasi'] = 'User/notifikasi/$1';
$route['user/level/hapus'] = 'User/hapus_level';

$route['login'] = 'LoginController/index';
$route['login/proses'] = 'LoginController/go_login';
$route['logout'] = 'LoginController/logout';

$route['plant/add'] = 'PlantController/tambahplant';
$route['plant'] = 'PlantController/index';
$route['plant/edit/(:any)'] = 'PlantController/updateplant/$1';
$route['plant/hapus'] = 'PlantController/deleteplant';

$route['department/add'] = 'DepartmentController/tambahdepartment';
$route['department'] = 'DepartmentController/index';
$route['department/(:any)/edit'] = 'DepartmentController/edit/$1';
$route['department/hapus'] = 'DepartmentController/hapus';

$route['master-dp/add'] = 'Master_dpController/create';
$route['master-dp'] = 'Master_dpController/index';
$route['master-dp/(:any)/edit'] = 'Master_dpController/edit/$1';
$route['master-dp/(:any)/detail'] = 'Master_dpController/detail/$1';
$route['master-dp/hapus'] = 'Master_dpController/hapus';

$route['ekstra/add'] = 'EkstraController/create';
$route['ekstra'] = 'EkstraController/index';
$route['ekstra/(:any)/edit'] = 'EkstraController/edit/$1';
$route['ekstra/hapus'] = 'EkstraController/hapus';

$route['surat/add'] = 'SuratController/create';
$route['surat'] = 'SuratController/index';
$route['surat/(:any)/edit'] = 'SuratController/edit/$1';
$route['surat/(:any)/print'] = 'SuratController/cetakSurat/$1';
$route['surat/hapus'] = 'SuratController/hapus';

$route['resign/add'] = 'ResignController/create';
$route['resign'] = 'ResignController/index';
$route['resign/popup/karyawan'] = 'ResignController/popup_karyawan';
$route['resign/(:any)/edit'] = 'ResignController/edit/$1';
$route['resign/aksi'] = 'ResignController/aksi';
$route['casualekstra/popup/karyawan'] = 'CasualEkstra/popup_karyawan';

$route['bonus'] = 'BonusController/index';
$route['bonus/add'] = 'BonusController/create';
$route['bonus/(:any)/(:any)/(:any)/detail'] = 'BonusController/detail_bonus/$1/$2/$3';
$route['bonus/(:any)/(:any)/(:any)/delete'] = 'BonusController/delete_bonus/$1/$2/$3';
$route['bonus/(:any)/(:any)/(:any)/detailrekap'] = 'BonusController/detail_rekap_bonus/$1/$2/$3';

$route['karyawan/add'] = 'KaryawanController/create';
$route['karyawan/(:any)/statistik'] = 'KaryawanController/statistik/$1';
$route['karyawan'] = 'KaryawanController/index';
$route['karyawan/(:any)/edit'] = 'KaryawanController/edit/$1';
$route['karyawan/hapus'] = 'KaryawanController/hapus';
$route['karyawan/statistik/view'] = 'KaryawanController/view_statistik';

$route['pajak/add'] = 'PajakController/create';
$route['pajak/(:any)/statistik'] = 'PajakController/statistik/$1';
$route['pajak'] = 'PajakController/index';
$route['pajak/(:any)/edit'] = 'PajakController/edit/$1';
$route['pajak/hapus'] = 'PajakController/hapus';

$route['mutasi/add'] = 'MutasiController/create';
$route['mutasi/(:any)/statistik'] = 'MutasiController/statistik';
$route['mutasi'] = 'MutasiController/index';
$route['mutasi/(:any)/edit'] = 'MutasiController/edit/$1';
$route['mutasi/hapus'] = 'MutasiController/hapus';

$route['dokumen/add'] = 'DokumenController/create';
$route['dokumen'] = 'DokumenController/index';
$route['dokumen/(:any)/edit'] = 'DokumenController/edit/$1';
$route['dokumen/(:any)/print'] = 'DokumenController/cetakDokumen/$1';
$route['dokumen/hapus'] = 'DokumenController/hapus';

$route['pengangkatan/add'] = 'PengangkatanController/create';
$route['pengangkatan/(:any)/statistik'] = 'PengangkatanController/statistik';
$route['pengangkatan'] = 'PengangkatanController/index';
$route['pengangkatan/(:any)/edit'] = 'PengangkatanController/edit/$1';
$route['pengangkatan/hapus'] = 'PengangkatanController/hapus';

$route['pajak/add'] = 'PajakController/tambahpajak';
$route['pajak/(:any)/statistik'] = 'PajakController/statistik';
$route['pajak'] = 'PajakController/index';
$route['pajak/(:any)/edit'] = 'PajakController/edit/$1';
$route['pajak/hapus'] = 'PajakController/hapus';

$route['memo/add'] = 'MemoController/create';
$route['memo/(:any)/statistik'] = 'MemoController/statistik';
$route['memo'] = 'MemoController/index';
$route['memo/(:any)/edit'] = 'MemoController/edit/$1';
$route['memo/hapus'] = 'MemoController/hapus';

$route['pindah_jam/add'] = 'PindahJamController/create';
$route['pindah_jam'] = 'PindahJamController/index';
$route['pindah_jam/(:any)/edit'] = 'PindahJamController/edit/$1';
$route['pindah_jam/hapus'] = 'PindahJamController/hapus';

$route['absensi/add'] = 'AbsensiController/create';
$route['absensi'] = 'AbsensiController/index';
$route['absensi/(:any)/statistik'] = 'AbsensiController/statistik/$1';
$route['absensi/(:any)/detail'] = 'AbsensiController/detail/$1';
$route['absensi/(:any)/edit'] = 'AbsensiController/edit/$1';
$route['absensi/(:any)/add'] = 'AbsensiController/create/$1';
$route['absensi/hapus'] = 'AbsensiController/hapus';
$route['absensi/import'] = 'AbsensiController/import_data';
$route['absensi/info-karyawan'] = 'AbsensiController/on_offplant';

$route['bpjs/(:any)/edit'] = 'BpjsController/edit/$1';
$route['bpjs'] = 'BpjsController/index';
$route['bpjs/add'] = 'BpjsController/tambah';

$route['gaji'] = 'GajiController/index';
$route['gaji/hapus'] = 'GajiController/hapus';
$route['gaji/import'] = 'GajiController/import_data';
$route['gaji/(:any)/(:any)/(:any)/(:any)/detail'] = 'GajiController/gaji_detail/$1/$2/$3/$4';
$route['gaji/(:any)/(:any)/(:any)/(:any)/detailrekap'] = 'GajiController/gaji_detail_rekap/$1/$2/$3/$4';
$route['gaji/(:any)/(:any)/(:any)/(:any)/detailcasual'] = 'GajiController/gaji_detail2/$1/$2/$3/$4';
$route['gaji/(:any)/(:any)/(:any)/detailrekapcasual'] = 'GajiController/gaji_casual_detail_rekap/$1/$2/$3';
$route['ThrController/(:any)/(:any)/detailrekap'] = 'ThrController/detailrekap/$1/$2';

$route['cuti-khusus/add'] = 'CutiKhususController/create';
$route['cuti-khusus'] = 'CutiKhususController/index';
$route['cuti-khusus/(:any)/edit'] = 'CutiKhususController/edit/$1';
$route['cuti-khusus/hapus'] = 'CutiKhususController/hapus';
$route['cuti-khusus/import'] = 'CutiKhususController/import_data';

$route['shedule-karyawan/add'] = 'ScheduleKaryawanController/create';
$route['shedule-karyawan'] = 'ScheduleKaryawanController/index';
$route['shedule-karyawan/(:any)/edit'] = 'ScheduleKaryawanController/edit/$1';
$route['shedule-karyawan/(:any)/detail'] = 'ScheduleKaryawanController/detail/$1';
$route['shedule-karyawan/hapus'] = 'ScheduleKaryawanController/hapus';
$route['schedule/import'] = 'ScheduleKaryawanController/import_data';

$route['bpjs/cetak'] = 'Laporan/bpjs_print_new';
$route['cetak/jam-kerja'] = 'JamKerjaController/cetak';
$route['cetak/absensi-karyawan'] = 'AbsensiController/cetak';
//$route['cetak/(:any)/(:any)/detail-plant-absensi-karyawan'] = 'AbsensiController/cetak_plant_detail/$1/$2';
$route['cetak/(:any)/detail-plant-absensi-karyawan'] = 'AbsensiController/cetak_plant_detail/$1/';
$route['cetak/(:any)/(:any)/detail-absensi-karyawan'] = 'AbsensiController/cetak_detail/$1/$2';
$route['cetak/karyawan'] = 'KaryawanController/view_print';
$route['karyawan/print/all'] = 'KaryawanController/cetak_all';
$route['cetak/(:any)/karyawan'] = 'KaryawanController/cetak_karyawan/$1';

$route['aprov/gaji/(:any)/(:any)/detail'] = 'Aprov/gaji_detail/$1/$2';
$route['aprov/bonus/(:any)/detail'] = 'Aprov/detail_bonus/$1';

$route['MasterTunjangan/(:any)/edit'] = 'MasterTunjangan/edit/$1';
$route['TunjanganKaryawan/(:any)/edit'] = 'TunjanganKaryawan/edit/$1';
$route['komisi'] = 'KomisiController/index';
$route['komisi/add'] = 'KomisiController/create';
$route['komisi/hapus'] = 'KomisiController/hapus';
$route['Laporan/rekapGaji'] = 'GajiController/rekap_gaji';
$route['laporan/rekapGajiCasual'] = 'GajiController/rekap_gajicasual';
$route['rekap/komisi'] = 'KomisiController/rekap_komisi';
$route['rekap/bonus'] = 'BonusController/rekap_bonus';
$route['komisi/(:any)/print'] = 'KomisiController/cetakkomisi/$1';
$route['bonus/(:any)/print'] = 'BonusController/cetakbonus/$1';
$route['bonus/print_all'] = 'BonusController/cetak_all';

$route['AsuransiController/(:any)/edit'] = 'AsuransiController/edit/$1';
$route['master-dp/(:any)/detail_rekap'] = 'Master_dpController/detail_rekap/$1';

$route['OmsetStandart'] = 'OmsetStandartController';
$route['BonusBaru'] = 'BonusBaruController';
$route['BonusBaru/add'] = 'BonusBaruController/addData';
$route['BonusBaru/(:any)/(:any)/(:any)/detail'] = 'BonusBaruController/detailData/$1/$2/$3';
$route['BonusBaru/(:any)/(:any)/(:any)/delete'] = 'BonusBaruController/deleteData/$1/$2/$3';
$route['Aprov/BonusBaru']	= 'BonusBaruController/approvIndex';
$route['BonusBaru/approveData/(:any)'] = 'BonusBaruController/approveData/$1';
$route['BonusBaru/cancelapproveData'] = 'BonusBaruController/cancelapproveData';
$route['Rekap/BonusBaru']	= 'BonusBaruController/rekapIndex';
$route['BonusBaru/rekapData']	= 'BonusBaruController/rekapData';
$route['BonusBaru/(:any)/(:any)/(:any)/detailRekap'] = 'BonusBaruController/detailDataRekap/$1/$2/$3';
$route['BonusBaru/rekapDataDetail']	= 'BonusBaruController/rekapDataDetail';

/* End of file routes.php */
/* Location: ./application/config/routes.php */