<?php
class Supplier_model extends CI_Model 
{
	
	function save_supplier_data($data)
	{
        $this->db->insert('supplier',$data);
        return true;
	}
	 function edit_supplier_data($data,$supplierid)
	{
	    $this->db->where('supplier_id', $supplierid);
        $this->db->update('supplier',$data);
        return true;
	}
    function delete_supplier_data($data,$supplierid)
	{
	     $this->db->where('supplier_id', $supplierid);
        $this->db->update('supplier_contact_details',$data);
	    $this->db->where('supplier_id', $supplierid);
        $this->db->update('supplier',$data);
        return true;
	}
		function add_conatct_supplier_data($data){
	  $this->db->insert('supplier_contact_details',$data);
        return true;   
	}
	 function delete_contact_supplier_data($data,$suppliercontact_id)
	{
	    $this->db->where('supplier_contact_id', $suppliercontact_id);
        $this->db->update('supplier_contact_details',$data);
        return true;
	}
    function edit_contact_save_supplier($data,$suppliercontact_id)
	{
	    $this->db->where('supplier_contact_id', $suppliercontact_id);
        $this->db->update('supplier_contact_details',$data);
        return true;
	}
	

}
?>
