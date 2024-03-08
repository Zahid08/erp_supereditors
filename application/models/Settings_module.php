<?php
class Settings_module extends CI_Model
{
    
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	public function save_sms_template_data($data){
	     $this->db->insert('sms_templates', $data);
        return true;
	}
	public function get_setting_data()
	{
	    $this->db->select('*');
        $this->db->from('setting');
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
	public function update($data)
	{
	 $key_data = array('USERNAME','TOKEN','SENDERID')   ;
	 
	    foreach($data as $key => $value)
	    {
	        $post = array('value' => $value);
	        
	         $this->db
		->where('key',$key_data[$key])
		->update('setting',$post); 
	    }
	    return true;
	}
	public function get_sms_data()
	{
	    $this->db->select('*');
        $this->db->from('sms_templates');
        
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
	
	public function change_status($data,$template_id){
	     $this->db->where('template_id', $template_id);
        $this->db->update('sms_templates',$data);
        return true;
	}
}
?>