<?php
class Patterns_model extends CI_Model
{
	
	function save_patterns_data($data)
	{
	    
        $this->db->insert('patterns',$data);
        return true;
	}
	function edit_patterns_data($data,$measureid)
	{
	    $this->db->where('patterns_id', $measureid);
        $this->db->update('patterns',$data);
        return true;
	}
	
    function delete_patterns_data($data,$measureid){
         $this -> db -> where('patterns_id', $measureid);
         $this -> db -> delete('patterns');
        return true;
    }



}
?>