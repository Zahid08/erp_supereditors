<?php
class Login_model extends CI_Model 
{
	
	function save_register_data($data)
	{
        $this->db->insert('user',$data);
        return true;
	}
	
	
	function checklogin($data)
	{
	    $email =  $data['email'];
	    $password = $data['password'];
        $getUser = $this->db->query("SELECT * FROM user WHERE isactive = 1 AND email ='$email' AND password = '$password'");
        
        
        
        $getUserCount = $getUser->num_rows();
        if($getUserCount == 1){
            $UserResult = $getUser->result();
            
            foreach($UserResult as $getUserResult){
                $user_id = $getUserResult->user_id;
                $name = $getUserResult->name;
                $email = $getUserResult->email;
                $role = $getUserResult->role;
            }
            
            //set session values
			$this->session->set_userdata('name', $name);
			$this->session->set_userdata('user_id', $user_id);
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('role', $role);
            return true;
        }else{
            return false;
        }
        
	}

	
}

?>