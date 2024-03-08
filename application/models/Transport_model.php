<?php
class Transport_model extends CI_Model 
{
	
	 function save_transport_data($data)
	{
	   $this->db->insert('transport',$data);
	   return true;
	}

   function edit_save_transport_data($data,$transport_id){
	     $this->db->where('transport_id', $transport_id);
        $this->db->update('transport',$data);
        return true;
	}
 
	function add_conatct_transport_data($data){
	  $this->db->insert('transport_contact_details',$data);
        return true;   
	}
	
	 function delete_transport_data($data,$transport_id){
	     $this->db->where('transport_id', $transport_id);
         $this->db->update('transport_contact_details',$data);
	     $this->db->where('transport_id', $transport_id);
        $this->db->update('transport',$data);
        return true;
	 }
	
	function delete_contact_transport_data($data,$transportcontact_id){
	    
	    $this->db->where('transport_contact_id', $transportcontact_id);
        $this->db->update('transport_contact_details',$data);
        return true;
	}
	
	function edit_contact_save_transportdata($data,$transport_contact_id)
	{
	   $this->db->where('transport_contact_id', $transport_contact_id);
        $this->db->update('transport_contact_details',$data);
        return true;
	}
	
}
?>