<?php
class Email_Config_model extends CI_Model
{
	function getConfig($param)
	{
	    if ($param=='admin') {
            $config['useragent'] = "CodeIgniter";
            $config['protocol'] = "SMTP";
            $config['_smtp_auth'] = TRUE;
            $config['smtp_host'] = "smtp.gmail.com";
            $config['smtp_user'] = "admin@supereditors.in";
            $config['smtp_pass'] = "pftkvtudzlfbybbz";
            $config['smtp_port'] = 487;
            $config['wordwrap'] = TRUE;
            $config['wrapchars'] = 76;
            $config['mailtype'] = "html";
        }elseif ($param=='info'){
            $config['useragent'] = "CodeIgniter";
            $config['protocol'] = "SMTP";
            $config['_smtp_auth'] = TRUE;
            $config['smtp_host'] = "smtp.gmail.com";
            $config['smtp_user'] = "info@supereditors.in";
            $config['smtp_pass'] = "nfdlpveydewlnyuh";
            $config['smtp_port'] = 487;
            $config['wordwrap'] = TRUE;
            $config['wrapchars'] = 76;
            $config['mailtype'] = "html";
        }elseif ($param=='marketing'){
            $config['useragent'] = "CodeIgniter";
            $config['protocol'] = "SMTP";
            $config['_smtp_auth'] = TRUE;
            $config['smtp_host'] = "smtp.gmail.com";
            $config['smtp_user'] = "marketing@supereditors.in";
            $config['smtp_pass'] = "trezvfrtccmyqcwj";
            $config['smtp_port'] = 487;
            $config['wordwrap'] = TRUE;
            $config['wrapchars'] = 76;
            $config['mailtype'] = "html";
        }else{
            $config['useragent'] = "CodeIgniter";
            $config['protocol'] = "SMTP";
            $config['_smtp_auth'] = TRUE;
            $config['smtp_host'] = "smtp.gmail.com";
            $config['smtp_user'] = "admin@supereditors.in";
            $config['smtp_pass'] = "pftkvtudzlfbybbz";
            $config['smtp_port'] = 487;
            $config['wordwrap'] = TRUE;
            $config['wrapchars'] = 76;
            $config['mailtype'] = "html";
        }

		return $config;
	}
	
}

?>
