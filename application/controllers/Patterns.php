<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patterns extends CI_Controller
{
public function index()
    {
        
    if ($this->session->userdata['role'] == 1){
            $this->load->view('user/patterns');
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
          
          if($_POST["pattern_id"]){
              
            $data=array(
              "pattern_name"=>$this->input->post('name'),
              "pattern_type"=>$this->input->post('pattern_type'),
              "is_active"=>1,
              "created_by" =>$this->session->userdata['user_id'],
              "created_date"=>date("Y-m-d")
          );
                     
          $pattern_id = $this->input->post('pattern_id');
          
          $this->load->model('Patterns_model');
          $response = $this->Patterns_model->edit_patterns_data($data,$pattern_id);
          
          $this->session->set_flashdata('pattern_message', 'Patterns Data Update Successfully');
          
          }else{
             $data=array(
                  "pattern_name"=>$this->input->post('name'),
                  "pattern_type"=>$this->input->post('pattern_type'),
                  "is_active"=>1,
                  "created_by" =>$this->session->userdata['user_id'],
                  "created_date"=>date("Y-m-d")
                  );
           
            $this->load->model('Patterns_model');
    
            $response = $this->Patterns_model->save_patterns_data($data); 
            
            $this->session->set_flashdata('pattern_message', 'Patterns Data Saved Successfully');
          }
          
      
         if ($response == true)
            { 
                 
                 redirect('Patterns');
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
         
     $pattern_id=$this->input->get('pattern_id');
      $data =array(
        'is_active' => '0'
	  );
      $this->load->model('Patterns_model');
     
     
     $response = $this->Patterns_model->delete_patterns_data($data,$pattern_id);
     
          
       if($response == true)
       {
          
        $this->session->set_flashdata('pattern_message', 'Pattern data Deleted Successfully');
        redirect('Patterns');
               
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
