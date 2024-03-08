<?php
class PaymentTerms_model extends CI_Model
{
	
	function save_payment_terms_data($data)
	{
	    
        $this->db->insert('payment_terms',$data);
        return true;
	}
	function edit_payment_terms_data($data,$measureid)
	{
	    $this->db->where('id', $measureid);
        $this->db->update('payment_terms',$data);
        return true;
	}
	
    function delete_patterns_data($measureid){
         $this -> db -> where('id', $measureid);
         $this -> db -> delete('payment_terms');
        return true;
    }



}
?>
