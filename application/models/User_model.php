<?php
class User_model extends CI_Model 
{
	
	function save_user_data($data)
	{
	    
        $this->db->insert('user',$data);
        return true;
	}
	function edit_user_data($data,$userid)
	{
	    $this->db->where('user_id', $userid);
        $this->db->update('user',$data);
        return true;
	}
	function bulktransfer_user_data($CurrentAgentdata,$TransferAgentdata,$userid)
	{
	    $this->db->where('user_id', $userid);
	    $this->db->where('end_date', NULL);
        $CurrentUserEnquiries = $this->db->get('agent_enquiry')->result();
        
        foreach($CurrentUserEnquiries as $getCurrentUserEnquiries){
            
            $this->db->where('user_id', $userid);
            $this->db->update('agent_enquiry',$CurrentAgentdata);
            
            $TransferAgentdata['enquiry_id'] = $getCurrentUserEnquiries->enquiry_id;
            
            $this->db->insert('agent_enquiry',$TransferAgentdata);
            
            
        }
        return true;
	}
}
?>