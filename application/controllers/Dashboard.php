<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    

	public function index()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/dashboard');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	
}

?>
