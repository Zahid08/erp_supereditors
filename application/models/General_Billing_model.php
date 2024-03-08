<?php
class General_Billing_model extends CI_Model
{

	 function save_billing_data($data)
	{
	   $this->db->insert('general_billing_entry',$data);
	   return true;
	}
	
   function get_billing_serial_maxid($company_name='')
   {
       	$this->db->select('*');
        $this->db->from('general_billing_entry');
	   $this->db->where('company_name',$company_name);
        $query = $this->db->get();

        if( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        }
        else
        {
            return false;
        }
   }
}

?>
