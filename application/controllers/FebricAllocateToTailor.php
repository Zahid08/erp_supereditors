<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FebricAllocateToTailor extends CI_Controller {

	public function index()
	{
		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/Febric_Allocate_To_Tailor',array('order_no'=>''));
		}else{
			$this->load->view('basic/login');
		}
	}
}
