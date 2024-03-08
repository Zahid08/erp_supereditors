<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    

	public function index()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/customerlist');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	public function save_offline_customer()
    {
        if ($this
                ->session
                ->userdata['role'] == (1 || 2))
        {
            $dataEnquiry = array(
                "name" => $this
                    ->input
                    ->post('party_name') ,
                    "pan_no" => $this->input->post('pan_no') ,
                    "company_name" => $this->input->post('company_name') ,
                    "tan_no" => $this->input->post('tan_no') ,
                    "credit_days" => $this->input->post('credit_days') ,
                    "credit_limit" => $this->input->post('credit_limit') ,
                    "gst_no" => $this->input->post('gst_no') ,
                    "state" => $this->input->post('state') ,
                    "billing_address" => $this->input->post('billing_address') ,
                    "shipping_address" => $this->input->post('shipping_address') ,
                    "is_customer" => 1,
                "created_datetime" => date('Y-m-d H:i:s') ,
                "created_by" => $this
                    ->session
                    ->userdata['user_id']
            );
            
            
            


            $companyname = $this->input->post('party_name');
            $companyCount = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1 AND  name = '$companyname' ORDER BY enquiry_id DESC")->result();
            if(count($companyCount) > 0) {
                $this
                    ->session
                    ->set_flashdata('po_message', 'Company Already Exists in the System');
                redirect('Po/customer_details');
            }

            $this
                ->load
                ->model('Enquiry_model');
               


            $response = $this
                ->Enquiry_model
                ->save_customer_data($dataEnquiry);
                
            

            if ($response == true)
            {

                $enquiryid = $this
                    ->db
                    ->insert_id();
                    
                    
                    
            $dataContact = array(
                "enquiry_id" => $enquiryid,
                    "name" => $this->input->post('pan_no') ,
                    "mobile_no" => $this->input->post('tan_no') ,
                    "email" => $this->input->post('credit_days'),
                    "created_datetime" => date('Y-m-d H:i:s') ,
                "created_by" => $this
                    ->session
                    ->userdata['user_id']
                );
            $response = $this
                ->Enquiry_model
                ->save_customer_contact_data($dataContact);

                $data_agentEnquiries = array(
                    "user_id" => $this->session->userdata['user_id'] ,
                    "enquiry_id" => $enquiryid ,
                    "start_date" => date('Y-m-d'),
                    "created_datetime" => date('Y-m-d H:i:s') ,
                    "created_by" => $this->session->userdata['user_id']
                );



                $this->load->model('Enquiry_model');

                $this->Enquiry_model->save_enquiryagent_data($data_agentEnquiries);

                 redirect('Po/customer_details?enquiry_id=' . $enquiryid);
            }
            else
            {
                echo "Insert error !";
            }
        }
        else
        {
            $this
                ->load
                ->view('basic/login');
        }
    }
	
}

?>
