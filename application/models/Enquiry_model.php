<?php
class Enquiry_model extends CI_Model 
{
	
	
	function save_customer_data($data)
	{
	    
        $this->db->insert('enquiry',$data);
        return true;
	}        
        public function EnquiryData($enquiry_id, $data)
        {
                $this->db->insert('enquiry', $data);
                return $this->db->insert_id();
        }
    
        public function ContactData($enquiry_id, $data)
        {
                $this->db->insert('contact_person', $data);
                return $this->db->insert_id();
        }
    
        public function AddressData($enquiry_id, $data)
        {
                $this->db->insert('address', $data);
                return $this->db->insert_id();
        } 
        public function AgentData($enquiry_id, $data)
        {
                $this->db->insert('agent_enquiry', $data);
                return $this->db->insert_id();
        }  
    
	function save_enquiry_data($data)
	{  
          $this->db->insert('enquiry',$data);
        return true;
	}
	function save_enquiryagent_data($data)
	{
	    
        $this->db->insert('agent_enquiry',$data);
   
        return true;
	}
	function save_address_data($data)
	{
	    
        $this->db->insert('address',$data);
        return true;
	}

	function save_contact_data($data)
	{
	    
        $this->db->insert('contact_person',$data);
		return $this->db->insert_id();
	}
	function save_customer_contact_data($data)
	{
	    
        $this->db->insert('contact_person',$data);
        return true;
	}
	
	function save_owner_data($data)
	{
	    
        $this->db->insert('owner_details',$data);
        return true;
	}
	function save_item_data($data)
	{
	    
        $this->db->insert('item_details',$data);
        return true;
	}
	function save_remark_data($data)
	{
	    
        $this->db->insert('remarks',$data);
        return true;
	}
	function save_appointment_data($data)
	{
	    
        $this->db->insert('appointment',$data);
        return true;
	}
	function confirm_appointment($appointmentID,$data)
	{
	    $this->db->where('appointment_id', $appointmentID);
            $this->db->update('appointment', $data);
     
            $this->db->set($data);
            $this->db->where('appointment_id',$appointmentID);
            $confirmAppointment = $this->db->update('appointment');
            if($confirmAppointment)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
        function update_data($data,$id)
	{ 
          $this->db->where('enquiry_id',$id);
          $this->db->set($data);
          $result = $this->db->update('enquiry');
          if($result)
          {
              return true;
          }else{
              return false;
          }
	}
	function save_quotation_data($data)
	{
	    
        $this->db->insert('quotation',$data);
        return true;
	}
	function save_quotation_heading_data($data)
	{
	    
        $this->db->insert('quotation_heading',$data);
        return true;
	}
	function save_quotation_heading_details_data($data,$enquiryid,$headingid)
	{
	    $this->db->set($data);
            $this->db->where('enquiry_id',$enquiryid);
            $this->db->where('heading_id',$headingid);
            $headingDetails = $this->db->update('quotation_heading');
            if($headingDetails)
            {
                return true;
            }
            else
            {
               return false;
            }
        $this->db->insert('quotation_heading',$data);
        return true;
	}
	function save_quotation_item_data($data)
	{
	    
        $this->db->insert('quotation_items',$data);
        return true;
	}
	function delete_quotation_item_data($quotation_item_id,$enquiryid)
	{
	    
        $this -> db -> where('quotation_item_id', $quotation_item_id);
        $this -> db -> delete('quotation_items');
        return true;
	}
	function delete_quotation_address_data($quotation_address_id,$enquiryid)
	{
	    
        $this -> db -> where('address_id', $quotation_address_id);
        $this -> db -> delete('address');
        return true;
	}
	function delete_quotation_contact_data($quotation_contact_id,$enquiryid)
	{
	    
        $this -> db -> where('contact_id', $quotation_contact_id);
        $this -> db -> delete('contact_person');
        return true;
	}
	function delete_quotation_owner_data($quotation_owner_id,$enquiryid)
	{
	    
        $this -> db -> where('owner_id', $quotation_owner_id);
        $this -> db -> delete('owner_details');
        return true;
	}
	function delete_quotation_itemdetails_data($quotation_itemdetails_id,$enquiryid)
	{
	    
        $this -> db -> where('item_id', $quotation_itemdetails_id);
        $this -> db -> delete('item_details');
        return true;
	}
	function delete_remark_data($remark_itemdetails_id,$enquiryid){
	    $this -> db -> where('remark_id', $remark_itemdetails_id);
        $this -> db -> delete('remarks');
        return true;
	    
	}
	function delete_quotation_appointment_data($quotation_appointment_id,$enquiryid)
	{
	    
        $this -> db -> where('appointment_id', $quotation_appointment_id);
        $this -> db -> delete('appointment');
        return true;
	}
	function edit_address_data($data,$addressid)
	{
	    
            $this->db->set($data);
            $this->db->where('address_id',$addressid);
            $UpdateAddress = $this->db->update('address');
            if($UpdateAddress)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_contact_data($data,$contactid)
	{
	    
            $this->db->set($data);
            $this->db->where('contact_id',$contactid);
            $UpdateContact = $this->db->update('contact_person');
            if($UpdateContact)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_owner_data($data,$ownerid)
	{
	    
            $this->db->set($data);
            $this->db->where('owner_id',$ownerid);
            $UpdateOwner = $this->db->update('owner_details');
            if($UpdateOwner)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_item_data($data,$itemid)
	{
	    
            $this->db->set($data);
            $this->db->where('item_id',$itemid);
            $UpdateOwner = $this->db->update('item_details');
            if($UpdateOwner)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_remark_data($data,$remark_id){
	    
            $this->db->set($data);
            $this->db->where('remark_id',$remark_id);
            $UpdateOwner = $this->db->update('remarks');
            if($UpdateOwner)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_appointment_data($data,$appointmentid)
	{
	    
            $this->db->set($data);
            $this->db->where('appointment_id',$appointmentid);
            $UpdateOwner = $this->db->update('appointment');
            if($UpdateOwner)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_item_data_quotation($data,$itemid)
	{
	    
            $this->db->set($data);
            $this->db->where('quotation_item_id',$itemid);
            $UpdateQuotationItem = $this->db->update('quotation_items');
            if($UpdateQuotationItem)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function edit_quotation_heading($data,$headingid)
	{
	    
            $this->db->set($data);
            $this->db->where('heading_id',$headingid);
            $UpdateQuotationHeading = $this->db->update('quotation_heading');
            if($UpdateQuotationHeading)
            {
                return true;
            }
            else
            {
               return false;
            }
	}
	function delete_enquiry_data($enquiryID,$data)
	{
	   
	    $this->db->where('enquiry_id', $enquiryID);
         $this->db->update('enquiry', $data);
         
         $this->db->set($data);
            $this->db->where('enquiry_id',$enquiryID);
            $deleteEnquiry = $this->db->update('enquiry');
            if($deleteEnquiry)
            {
                return true;
            }
            else
            {
               return false;
            }
         
            
	}
	
}

?>