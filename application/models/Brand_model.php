<?php
class Brand_model extends CI_Model 
{
  public function get_brand_typedata(){
      $this->db->select('*');
        $this->db->from('brand');
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
  
	public function get_fabricdata($brand_id){
	$this->db->select('*,b.name as uname');
        $this->db->from('fabric a');
        $this->db->join('user b','a.created_by = b.user_id');
        $this->db->where('brand_id', $brand_id );
        $this->db->where('is_active', '1' );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            $query->num_rows();
        }
	
}
public function delete_brand($brand_id,$data){
    

	  return $this->db
	  
			->where('brand_id', $brand_id)
			->update('brand',$data);
	}
	public function delete_all_fabric($brand_id,$data1)
	{
	     return $this->db
			->where('brand_id', $brand_id)
			->update('fabric',$data1);
	}
	public function update_fabric($post,$fabricid){
	    	return $this->db
			->where('fabric_id', $fabricid)
			->update('fabric',$post);
	    
	}
	public function delete_fabric($fabricid,$data){
	      return $this->db
			->where('fabric_id', $fabricid)
			->update('fabric',$data);
	}

}
?>