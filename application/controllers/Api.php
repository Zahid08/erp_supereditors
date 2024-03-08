<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
 public function index()
    {
        $query=$this->db->query("select * from user");
        echo json_encode($query->result());
    }
   
   
   
   
}

?>