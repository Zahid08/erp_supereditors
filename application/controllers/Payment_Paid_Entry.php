<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_Paid_Entry extends CI_Controller
{
public function index()
    {
        
         if ($this->session->userdata['role'] == 1){
            $this->load->view('user/purchase_paid_entry');
         }else{
              $this->load->view('basic/login');
         }
    
        
    }
    public function edit_transport_purchase(){
        
         $data=array(  "purchase_transport_id"=>$this->input->post('purchase_transport_id'),
                       "total_amt_paid"=>$this->input->post('total_amt_paid'),
                       "total_tds_ded" => $this->input->post('total_tds_ded'),
                     "total_other_ded"=>$this->input->post('total_other_ded'),
                       "total_adv_adj" => $this->input->post('total_adv_adj'),
                       "payment_mode" => $this->input->post('payment_mode'),
                       "cheq_no" => $this->input->post('cheq_no'),
                       "bank_details" => $this->input->post('bank_details'),
                       "dated" => $this->input->post('dated'),
                       "pay_paid_by" => $this->input->post('pay_paid_by'),
                       "balace" => $this->input->post('balace'),
                       "updated_by" =>  $this->session->userdata['user_id'],
                 "updated_date" => date("Y-m-d"));
        //print_r($data);
         $purchase_transport_id = $this->input->post('purchase_transport_id');
        $this->load->model(Purchase_model);
         $response = $this->Purchase_model->edit_purchase_transport_data($data,$purchase_transport_id);
          if ($response == true)
            {
               
                $this->session->set_flashdata('message', 'Purachase Transport Data Updated Successfully');
                redirect('Payment_Paid_Entry');
            }
            else
            {
                echo "Insert error !";
            }  
    }
}