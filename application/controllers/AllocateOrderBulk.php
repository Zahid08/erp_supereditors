<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AllocateOrderBulk extends CI_Controller {

	public function index()
	{
		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/allocate_order_bulk',array('order_no'=>''));
		}else{
			$this->load->view('basic/login');
		}
	}

	public function febric_allicate_tailor()
	{
		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/febcric_allocate_tailor',array('order_no'=>''));
		}else{
			$this->load->view('basic/login');
		}
	}
}
