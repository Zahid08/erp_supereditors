<?php
class Karigar_Item_Rated_Link_model extends CI_Model
{
    
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_karigar_item_rated_Data($id)
	{
	    $this->db->select('b.name,a.*');
        $this->db->from('karigar_item_rate a');
        $this->db->join('user b','a.created_by = b.user_id');
        $this->db->where('a.is_active', '1' );
        $this->db->where('a.created_by', $id );
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

	public function update_karigar_item_rated_data($id,$data)
	{
        $this->db->where('id', $id);
        $this->db->update('karigar_item_rate',$data);
        return true;
	}

	public function add_karigar_Item_Rate_data($karigarData)
	{
        $insert = $this->db->insert('karigar_item_rate',$karigarData);
        return $this->db->insert_id();
	}
}
?>