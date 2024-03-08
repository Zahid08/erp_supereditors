<?php
class GenerateCode_model extends CI_Model
{

	 function save_generated_code_data($data)
	{
	   $this->db->insert('code_generations',$data);
	   return true;
	}
	function get_generated_code()
   {
       	$this->db->select('*');
        $this->db->from('code_generations');
        $query = $this->db->get();

        if( $query->num_rows() > 0 )
        {
            return $query;
        }
        else
        {
            return false;
        }
   }
   
   	function save_code_mesurement($data)
	{
		$this->db->insert('code_measurement',$data);
		return true;
	}
	

	function save_authorization_data($data)
	{
		$this->db->insert('code_authorizations',$data);
		return true;
	}

	function save_authorization_details_data($data)
	{
		$this->db->insert('code_authorizations_details',$data);
		return true;
	}

}

?>
