<?php
class Communication_model extends CI_Model 
{
	
	function save_communication_data($data)
	{
	    
        $this->db->insert('communication',$data);
        return true;
	}
	function save_sms_communication_data($data)
	{
	    
        $this->db->insert('sms_communication',$data);
        return true;
	}
	function update_sms_communication_data($data,$smscommunicationID)
	{
            $this->db->set($data);
            $this->db->where('sms_communication_id',$smscommunicationID);
            $UpdateCommunication = $this->db->update('sms_communication');
            if($UpdateCommunication)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function update_communication_data($data,$communicationID)
	{
            $this->db->set($data);
            $this->db->where('communication_id',$communicationID);
            $UpdateCommunication = $this->db->update('communication');
            if($UpdateCommunication)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	
	
	
}

?>