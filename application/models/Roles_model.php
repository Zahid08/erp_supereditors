<?php
class Roles_model extends CI_Model 
{
	
	function save_role_data($data)
	{
	    
        $this->db->insert('roles',$data);
        return true;
	}
	function edit_role_data($data,$roleid)
	{
	    $this->db->where('id', $roleid);
        $this->db->update('roles',$data);
        return true;
	}
}
?>