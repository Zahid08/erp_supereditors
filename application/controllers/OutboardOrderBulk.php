<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OutboardOrderBulk extends CI_Controller {

	public function index()
	{
		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/outboard_order_bulk',array('order_no'=>''));
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

	public function getKarigarName(){
		$karigarId = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigarId'))));
		$customerName = $this->db->query("SELECT * FROM karigar_master WHERE id='".$karigarId."'")->row();
		echo $customerName->karigar_type;
		exit();
	}

	public function get_febric_name(){
		$brandId = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('brandId'))));

		$this->db->select();
		$this->db->from('fabric');
		$this->db->where('brand_id',$brandId);
		$this->db->where('is_active','1');
		$query = $this->db->get();

		if( $query->num_rows() > 0 )
		{
			print_r(json_encode($query->result_array()));
			exit();
		}
		else
		{
			return false;
		}

	}
}
