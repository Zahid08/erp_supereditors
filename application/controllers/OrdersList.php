<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrdersList extends CI_Controller
{
    
     public function __construct()
    {
        parent:: __construct();
        //$this->load->model('OrdersList_model');
        //echo "ok";
    }
      
    public function index()
    {
        if ($this->session->userdata['role'] == 1)
        {
            $this->load->view('user/Orders_details');
        }else{
            $this->load->view('basic/login');
        }
        
    }
    public function view_details()
      {          
          if ($this->session->userdata['role'] == 1)
          {
            $this->load->view('user/orderDetails');
          }else{
             $this->load->view('basic/login');
          }
      }
}
?>