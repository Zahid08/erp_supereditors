<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentTerms extends CI_Controller
{
public function index()
    {
        
    if ($this->session->userdata['role'] == 1){
            $this->load->view('user/payment_terms');
         }else{
              $this->load->view('basic/login');
         }
        
    }
    public function add_patterns()
      {
          if ($this->session->userdata['role'] == 1){
            $this->load->view('user/add_patterns');
          }else{
             $this->load->view('basic/login');
          }
      }
      
      public function save_or_update(){
          
          if($_POST["payment_term_id"]){
              
            $data=array(
              "payment_terms"=>$this->input->post('name'),
              "status"=>$this->input->post('status'),
              "created_by" =>$this->session->userdata['user_id'],
              "created_date"=>date("Y-m-d")
          );
                     
          $payment_term_id = $this->input->post('payment_term_id');
          
          $this->load->model('PaymentTerms_model');
          $response = $this->PaymentTerms_model->edit_payment_terms_data($data,$payment_term_id);
          
          $this->session->set_flashdata('pattern_message', 'Payment Terms Data Update Successfully');
          
          }else{
             $data=array(
				 "payment_terms"=>$this->input->post('name'),
				 "status"=>$this->input->post('status'),
				 "created_by" =>$this->session->userdata['user_id'],
				 "created_date"=>date("Y-m-d")
			 );
           
            $this->load->model('PaymentTerms_model');

            $response = $this->PaymentTerms_model->save_payment_terms_data($data);
            
            $this->session->set_flashdata('pattern_message', 'Patterns Data Saved Successfully');
          }
          
      
         if ($response == true)
            { 
                 
                 redirect('PaymentTerms');
            }
            else
            {
                echo "Insert error !";
            }
          
        }
        
     public function edit_patterns(){
             if ($this->session->userdata['role'] == 1){
            $this->load->view('user/edit_pattern');
        }else{
            $this->load->view('basic/login');
        }
     }
        
        
     public function delete_pattern(){
         
     $pattern_id=$this->input->get('term_id');

      $this->load->model('PaymentTerms_model');

     $response = $this->PaymentTerms_model->delete_patterns_data($pattern_id);
     
          
       if($response == true)
       {
          
        $this->session->set_flashdata('pattern_message', 'Payment Terms data Deleted Successfully');
        redirect('PaymentTerms');

       }
      else
        {
            echo "Insert error !";
        }
      }

	public function getPattern(){
		$id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
		$this->db->select();
		$this->db->from('patterns');
		$this->db->where('pattern_type', $id);
		$this->db->where('is_active', '1');
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$itemData=$query->result_array();
			print_r(json_encode($itemData));
			exit();
		}
	}
}
?>
