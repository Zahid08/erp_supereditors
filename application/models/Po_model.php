<?php
class Po_model extends CI_Model 
{
	

	function update_po_data($data,$enquiryid)
	{
            $this->db->set($data);
            $this->db->where('enquiry_id',$enquiryid);
            $UpdatePO = $this->db->update('enquiry');
            if($UpdatePO)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function update_po_file_data($data)
	{
            
            
            $InsertPO = $this->db->insert('po_document',$data);
            if($InsertPO)
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