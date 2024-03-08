<?php
class Email_modal extends CI_Model
{
    
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_email_data($id)
	{
	    $this->db->select('b.name,a.*');
        $this->db->from('client_emails a');
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
	public function update_email($id,$data)
	{
	    $this->db->select('*');
        $this->db->from('client_emails');
        $this->db->where('is_active', '1' );
        $this->db->where('created_by', $data['updated_by'] );
        $this->db->where('email', $data['email']);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return false;
        }
        else
        {
	        return $this->db
		    ->where('client_email_id', $id)
		    ->update('client_emails',$data);
        }
	}
	public function add_email($email_data,$email_address)
	{
	    $this->db->select('*');
        $this->db->from('client_emails');
        $this->db->where('is_active', '1' );
        $this->db->where('created_by', $email_data['created_by'] );
        $this->db->where('email', $email_address);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return false;
        }
        else
        {
            $insert = $this->db->insert('client_emails',$email_data);
            return $this->db->insert_id();
        }
	}
}
?>