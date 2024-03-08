<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends CI_Controller {
    
    

	public function index()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/po');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	public function customer_details()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/view_customer_details');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	 public function update_po_data()
    {
        
        if ($this
                ->session
                ->userdata['role'] == (1 || 2))
        {

            $enquiryid = $this->input->post('enquiry_id');
            $this->load->library('upload');
            
            $image = array();
            $ImageCount = count($_FILES['po_doc']['name']);
            /*echo $ImageCount;
            exit;*/
            for($i = 0; $i < $ImageCount; $i++){
                $_FILES['file']['name']       = time().$_FILES['po_doc']['name'][$i];
                $_FILES['file']['type']       = $_FILES['po_doc']['type'][$i];
                $_FILES['file']['tmp_name']   = $_FILES['po_doc']['tmp_name'][$i];
                $_FILES['file']['error']      = $_FILES['po_doc']['error'][$i];
                $_FILES['file']['size']       = $_FILES['po_doc']['size'][$i];
                
                
                //upload to a Folder
                $config['upload_path'] = 'assets/client_asstes/PO';
                $config['allowed_types'] = 'jpg|png|pdf|jpeg';
    
                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
                // Upload file to server
                if(!$this->upload->do_upload('file')){
                    $error = array(
                    'error' => $this->upload->display_errors()
                );
                //print_r($error);
                     $this->session->set_flashdata('po_message', $error['error']);
                    redirect('Po?enquiry_id=' . $enquiryid);
                exit;
                }else{
                    // Uploaded file data
                    $imageData = $this->upload->data();
                     $uploadImgData[$i]['po_doc'] = $imageData['file_name'];
                }
                
                $data = array("enquiry_id" => $enquiryid,
                              "document_name" =>   $_FILES['file']['name'],
                              "created_by" => $this->session->userdata['user_id'],
                              "created_date" => date('Y-m-d')
                                );
                $this->load->model('Po_model');
                $response = $this->Po_model->update_po_file_data($data);
            }
            //upload to a Folder
            //send mail --start
            
            if (1==1)
            {

                $data = array(
                    
                    "pan_no" => $this->input->post('pan_no') ,
                    "tan_no" => $this->input->post('tan_no') ,
                    "credit_days" => $this->input->post('credit_days') ,
                    "credit_limit" => $this->input->post('credit_limit') ,
                    "gst_no" => $this->input->post('gst_no') ,
                    "state" => $this->input->post('state') ,
                    "billing_address" => $this->input->post('billing_address') ,
                    "shipping_address" => $this->input->post('shipping_address') ,
                    "is_customer" => $this->input->post('customer'),
                    "company_name" => $this->input->post('company_name'),
                    /*"attachment" => $fileName,*/
                    "created_datetime" => date('Y-m-d H:i:s') ,
                    "created_by" => $this->session->userdata['user_id']
                );

                $this->load->model('Po_model');

                $response = $this->Po_model->update_po_data($data,$enquiryid);

                if ($response == true)
                {
                    //send mail --end
                    $this->session->set_flashdata('po_message', 'Successfully Converted to Customer');
                    redirect('Po?enquiry_id=' . $enquiryid);

                }
                else
                {
                    echo "Insert error !";
                }

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
