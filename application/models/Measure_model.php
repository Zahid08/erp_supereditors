<?php
class Measure_model extends CI_Model 
{
	
	function save_measure_data($data)
	{
	    
        $this->db->insert('measure',$data);
        return true;
	}
	function edit_measure_data($data,$measureid)
	{
	    $this->db->where('measure_id', $measureid);
        $this->db->update('measure',$data);
        return true;
	}
    function delete_measure_data($data,$measureid){
         $this->db->where('measure_id', $measureid);
        $this->db->update('measure',$data);
        return true;
    }



}
?>