<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Auth library
 *
 * @author
 */
class Auth{
   var $CI = NULL;
   function __construct()
   {
      // get CI's object
      $this->CI =& get_instance();
   }
   // untuk mengecek apakah user sudah login/belum

   function login_admin($user,$pass)
   {
      $cek=$this->CI->db->where('username',$user)
                        ->where('password',md5($pass))
                        ->where('status','Aktif')
                        ->get('tab_users')
                        ->row();
      $row=count($cek);
      if ($row==1) {
         return $cek;
      } else {
         return false;
      }
   }
   // untuk validasi di setiap halaman yang mengharuskan authentikasi
   function restrict()
   {
$data=$this->CI->session->userdata('username');      
if(!empty($data))
      {
         $user=$this->CI->session->userdata('username');
         $pass=$this->CI->session->userdata('view_password');
         $cek_login=$this->login_admin($user,$pass);
         
         if ($cek_login==false) {
            echo "<script>alert('Anda telah keluar dari sistem'); window.location='".base_url()."login';</script>";
         }
      } else {
            echo "<script>alert('Anda telah keluar dari sistem'); window.location='".base_url()."login';</script>";
      }
   }
}