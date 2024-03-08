<?php
class Items_model extends CI_Model
{
    
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_item_typedata()
	{
	    $this->db->select('*');
        $this->db->from('item_type');
        $this->db->where('is_active', '1' );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
	}
	public function get_itemdata($item_type_id)
	{
	    $this->db->select('*,b.name as uname');
        $this->db->from('items a');
        $this->db->join('user b','a.created_by = b.user_id');
        $this->db->where('item_type_id', $item_type_id );
        $this->db->where('is_active', '1' );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
	}
	public function update_item($post,$id)
	{
	    			return $this->db
			->where('item_id', $id)
			->update('items',$post); 
	}
	public function delete_item($id,$data)
	{
			  return $this->db
			->where('item_id', $id)
			->update('items',$data); 
	}
	public function delete_type($id,$data)
	{
	    return $this->db
			->where('item_type_id', $id)
			->update('item_type',$data); 
	}
	public function delete_all_items($id,$data)
	{
	    			  return $this->db
			->where('item_type_id', $id)
			->update('items',$data);
	}
	public function get_type()
	{
	    $this->db->select();
        $this->db->from('item_type');
        $this->db->where('is_active', '1' );
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
	}
	public function get_brand()
	{
	    $this->db->select();
        $this->db->from('brand');
        $this->db->where('is_active', '1' );
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
	}
	public function get_itemname($id)
	{
	   	$this->db->select();
        $this->db->from('fabric');
        $this->db->where('brand_id', $id);
        $this->db->where('is_active', '1');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        } 
	}
}
?>