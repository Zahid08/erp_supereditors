<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Measure extends CI_Controller
{
public function index()
    {
        
    if ($this->session->userdata['role'] == 1){
            $this->load->view('user/measure');
         }else{
              $this->load->view('basic/login');
         }
        
    }
    public function add_measure()
      {
           
            $this->load->view('user/add_measure');
          
      }
      
      public function save_measure_data(){
          $data=array("measure_name"=>$this->input->post('name'),
                      "short_code"=>$this->input->post('short_code'),
                      "is_active"=>1,
                      "created_by" =>$this->session->userdata['user_id'],
                      "created_date"=>date("Y-m-d")
                      );
               
       $this->load->model('Measure_model');
        
        $response = $this->Measure_model->save_measure_data($data);
        
        if ($response == true)
            { 
                
                 $this->session->set_flashdata('measure_message', 'Measure Data Saved Successfully');
                 redirect('Measure/add_measure');
            }
            else
            {
                echo "Insert error !";
            }
          
        }
        public function edit_measure(){
             if ($this->session->userdata['role'] == 1){ 
         $this->load->view('user/edit_measure');
        }else{
            $this->load->view('basic/login');
        }
        }
        
      public function save_edit_measure_data(){
         // print_r($_POST);
               $data=array("measure_name"=>$this->input->post('name'),
                      "short_code"=>$this->input->post('short_code'),
                      "created_by" =>$this->session->userdata['user_id'],
                      "created_date"=>date("Y-m-d")
                      );
                     
          $measureid = $this->input->post('measure_id');
          
          $this->load->model('Measure_model');
          $response = $this->Measure_model->edit_measure_data($data,$measureid);
        if ($response == true)
            {
                
                $this->session->set_flashdata('measure_message', 'Measure Data Updated Successfully');
                redirect('Measure');
            }
            else
            {
                echo "Insert error !";
            }
          
      }
        public function delete_measure(){
     $measureid=$this->input->get('measure_id');   
    // print_r($measureid);
     
          $data = [
            'is_active' => '0'
        ];
      $this->load->model('Measure_model');
     
     $response = $this->Measure_model->delete_measure_data($data,$measureid);
     
          
       if($response == true)
       {
          
        $this->session->set_flashdata('measure_message', 'Measure data Deleted Successfully');
        redirect('Measure');
               
       }
      else
        {
            echo "Insert error !";
            
            
        }
    
          
      }
      

}
?>