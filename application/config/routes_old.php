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

$route['jadwal/add'] = 'jamKerjaController/create';
$route['jadwal'] = 'jamKerjaController/index';
$route['jadwal/(:any)/edit'] = 'jamKerjaController/edit/$1';
$route['jadwal/hapus'] = 'jamKerjaController/hapus';
$route['jadwal/get_all'] = 'jamKerjaController/get_all';
$route['jadwal/import'] = 'jamKerjaController/import_data';

$route['liburan/add'] = 'liburController/create';
$route['liburan'] = 'liburController/index';
$route['liburan/(:any)/edit'] = 'liburController/edit/$1';
$route['liburan/hapus'] = 'liburController/hapus';
$route['liburan/import'] = 'liburController/import_data';

$route['perizinan/add'] = 'izinController/create';
$route['perizinan'] = 'izinController/index';
$route['perizinan/(:any)/edit'] = 'izinController/edit/$1';
$route['perizinan/hapus'] = 'izinController/hapus';

//administrasi
$route['mutasi'] = 'mutasiController/index';
$route['mutasi/see'] = 'mutasiController/lihatmutasi';
$route['mutasi/print'] = 'mutasiController/cetakmutasi';

$route['peringatan'] = 'spController/index';
$route['peringatan/print'] = 'spController/cetaksp';
$route['sp/add'] = 'spController/create';
$route['sp/hapus'] = 'spController/hapus';

$route['pengangkatan'] = 'pengangkatanController/index';
$route['pengangkatan/see'] = 'pengangkatanController/lihatpengangkatan';
$route['pengangkatan/print'] = 'pengangkatanController/cetakpengangkatan';
$route['memo'] = 'memoController/index';

$route['cuti/add'] = 'cutiController/create';
$route['cuti'] = 'cutiController/index';
$route['cuti/(:any)/edit'] = 'cutiController/edit/$1';
$route['cuti/hapus'] = 'cutiController/hapus';

$route['user/level/add'] = 'user/create_level';
$route['user/level'] = 'user/user_level';
$route['user/level/(:any)/edit'] = 'user/edit_level/$1';
$route['user/(:any)/edit'] = 'user/edit/$1';
$route['user/level/(:any)/privillage'] = 'user/all_menu/$1';
$route['user/level/(:any)/notifikasi'] = 'user/notifikasi/$1';
$route['user/level/hapus'] = 'user/hapus_level';

$route['login'] = 'loginController/index';
$route['login/proses'] = 'loginController/go_login';
$route['logout'] = 'loginController/logout';

$route['plant/add'] = 'plantController/tambahplant';
$route['plant'] = 'plantController/index';
$route['plant/edit/(:any)'] = 'plantController/updateplant/$1';
$route['plant/hapus'] = 'plantController/deleteplant';

$route['department/add'] = 'departmentController/tambahdepartment';
$route['department'] = 'departmentController/index';
$route['department/(:any)/edit'] = 'departmentController/edit/$1';
$route['department/hapus'] = 'departmentController/hapus';

$route['master-dp/add'] = 'master_dpController/create';
$route['master-dp'] = 'master_dpController/index';
$route['master-dp/(:any)/edit'] = 'master_dpController/edit/$1';
$route['master-dp/(:any)/detail'] = 'master_dpController/detail/$1';
$route['master-dp/hapus'] = 'master_dpController/hapus';

$route['ekstra/add'] = 'ekstraController/create';
$route['ekstra'] = 'ekstraController/index';
$route['ekstra/(:any)/edit'] = 'ekstraController/edit/$1';
$route['ekstra/hapus'] = 'ekstraController/hapus';

$route['surat/add'] = 'suratController/create';
$route['surat'] = 'suratController/index';
$route['surat/(:any)/edit'] = 'suratController/edit/$1';
$route['surat/(:any)/print'] = 'suratController/cetakSurat/$1';
$route['surat/hapus'] = 'suratController/hapus';

$route['resign/add'] = 'resignController/create';
$route['resign'] = 'resignController/index';
$route['resign/popup/karyawan'] = 'resignController/popup_karyawan';
$route['resign/(:any)/edit'] = 'resignController/edit/$1';
$route['resign/aksi'] = 'resignController/aksi';
$route['casualEKstra/popup/karyawan'] = 'casualEkstra/popup_karyawan';

$route['bonus'] = 'bonusController/index';
$route['bonus/add'] = 'bonusController/create';
$route['bonus/(:any)/detail'] = 'bonusController/detail_bonus/$1';

$route['karyawan/add'] = 'karyawanController/create';
$route['karyawan/(:any)/statistik'] = 'karyawanController/statistik/$1';
$route['karyawan'] = 'karyawanController/index';
$route['karyawan/(:any)/edit'] = 'karyawanController/edit/$1';
$route['karyawan/hapus'] = 'karyawanController/hapus';
$route['karyawan/statistik/view'] = 'karyawanController/view_statistik';

$route['pajak/add'] = 'pajakController/create';
$route['pajak/(:any)/statistik'] = 'pajakController/statistik/$1';
$route['pajak'] = 'pajakController/index';
$route['pajak/(:any)/edit'] = 'pajakController/edit/$1';
$route['pajak/hapus'] = 'pajakController/hapus';

$route['mutasi/add'] = 'mutasiController/create';
$route['mutasi/(:any)/statistik'] = 'mutasiController/statistik';
$route['mutasi'] = 'mutasiController/index';
$route['mutasi/(:any)/edit'] = 'mutasiController/edit/$1';
$route['mutasi/hapus'] = 'mutasiController/hapus';

$route['dokumen/add'] = 'dokumenController/create';
$route['dokumen'] = 'dokumenController/index';
$route['dokumen/(:any)/edit'] = 'dokumenController/edit/$1';
$route['dokumen/(:any)/print'] = 'dokumenController/cetakDokumen/$1';
$route['dokumen/hapus'] = 'dokumenController/hapus';

$route['pengangkatan/add'] = 'pengangkatanController/create';
$route['pengangkatan/(:any)/statistik'] = 'pengangkatanController/statistik';
$route['pengangkatan'] = 'pengangkatanController/index';
$route['pengangkatan/(:any)/edit'] = 'pengangkatanController/edit/$1';
$route['pengangkatan/hapus'] = 'pengangkatanController/hapus';

$route['pajak/add'] = 'pajakController/tambahpajak';
$route['pajak/(:any)/statistik'] = 'pajakController/statistik';
$route['pajak'] = 'pajakController/index';
$route['pajak/(:any)/edit'] = 'pajakController/edit/$1';
$route['pajak/hapus'] = 'pajakController/hapus';

$route['memo/add'] = 'memoController/create';
$route['memo/(:any)/statistik'] = 'memoController/statistik';
$route['memo'] = 'memoController/index';
$route['memo/(:any)/edit'] = 'memoController/edit/$1';
$route['memo/hapus'] = 'memoController/hapus';

$route['pindah_jam/add'] = 'pindahJamController/create';
$route['pindah_jam'] = 'pindahJamController/index';
$route['pindah_jam/(:any)/edit'] = 'pindahJamController/edit/$1';
$route['pindah_jam/hapus'] = 'pindahJamController/hapus';

$route['absensi/add'] = 'absensiController/create';
$route['absensi'] = 'absensiController/index';
$route['absensi/(:any)/statistik'] = 'absensiController/statistik/$1';
$route['absensi/(:any)/detail'] = 'absensiController/detail/$1';
$route['absensi/(:any)/edit'] = 'absensiController/edit/$1';
$route['absensi/(:any)/add'] = 'absensiController/create/$1';
$route['absensi/hapus'] = 'absensiController/hapus';
$route['absensi/import'] = 'absensiController/import_data';
$route['absensi/info-karyawan'] = 'absensiController/on_offplant';

$route['bpjs/(:any)/edit'] = 'bpjsController/edit/$1';
$route['bpjs'] = 'bpjsController/index';
$route['bpjs/add'] = 'bpjsController/create';

$route['gaji'] = 'gajiController/index';
$route['gaji/hapus'] = 'gajiController/hapus';
$route['gaji/import'] = 'gajiController/import_data';
$route['gaji/(:any)/(:any)/detail'] = 'gajiController/gaji_detail/$1/$2';

$route['cuti-khusus/add'] = 'cutiKhususController/create';
$route['cuti-khusus'] = 'cutiKhususController/index';
$route['cuti-khusus/(:any)/edit'] = 'cutiKhususController/edit/$1';
$route['cuti-khusus/hapus'] = 'cutiKhususController/hapus';
$route['cuti-khusus/import'] = 'cutiKhususController/import_data';

$route['shedule-karyawan/add'] = 'scheduleKaryawanController/create';
$route['shedule-karyawan'] = 'scheduleKaryawanController/index';
$route['shedule-karyawan/(:any)/edit'] = 'scheduleKaryawanController/edit/$1';
$route['shedule-karyawan/(:any)/detail'] = 'scheduleKaryawanController/detail/$1';
$route['shedule-karyawan/hapus'] = 'scheduleKaryawanController/hapus';
$route['schedule/import'] = 'scheduleKaryawanController/import_data';

$route['bpjs/cetak'] = 'laporan/bpjs_print';
$route['cetak/jam-kerja'] = 'jamKerjaController/cetak';
$route['cetak/absensi-karyawan'] = 'absensiController/cetak';
$route['cetak/karyawan'] = 'karyawanController/view_print';
$route['karyawan/print/all'] = 'karyawanController/cetak_all';
$route['cetak/(:any)/karyawan'] = 'karyawanController/cetak_karyawan/$1';

$route['aprov/gaji/(:any)/(:any)/detail'] = 'aprov/gaji_detail/$1/$2';
$route['aprov/bonus/(:any)/detail'] = 'aprov/detail_bonus/$1';

$route['masterTunjangan/(:any)/edit'] = 'masterTunjangan/edit/$1';
$route['tunjanganKaryawan/(:any)/edit'] = 'tunjanganKaryawan/edit/$1';
$route['komisi'] = 'komisiController/index';
$route['komisi/add'] = 'komisiController/create';
$route['komisi/hapus'] = 'komisiController/hapus';
$route['laporan/rekapGaji'] = 'gajiController/rekap_gaji';
$route['rekap/komisi'] = 'komisiController/rekap_komisi';
$route['rekap/bonus'] = 'bonusController/rekap_bonus';
$route['komisi/(:any)/print'] = 'komisiController/cetakkomisi/$1';
$route['bonus/(:any)/print'] = 'bonusController/cetakbonus/$1';
$route['bonus/print_all'] = 'bonusController/cetak_all';

$route['asuransiController/(:any)/edit'] = 'AsuransiController/edit/$1';
$route['master-dp/(:any)/detail_rekap'] = 'Master_dpController/detail_rekap/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */