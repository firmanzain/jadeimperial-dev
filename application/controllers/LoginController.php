<?php

class LoginController extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	  {
	  	$this->load->view('login');
	  }

	public function go_login()
	  {
	  	$user=$this->input->post('email');
	  	$pass=$this->input->post('password');
	    $user=$this->auth->login_admin($user,$pass);
		if ($user==true) {
			$this->session->set_userdata($user);
			$data['hasil']=1;
			echo json_encode($data);
		} else {
			$data['hasil']=0;
			echo json_encode($data);
			//redirect('login');
		}	   
	  }
  public function logout()
	  {
	  	$this->session->sess_destroy();
	  	redirect('login','refresh');
	  }
}