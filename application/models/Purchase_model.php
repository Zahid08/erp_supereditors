<?php
class Purchase_model extends CI_Model 
{
	 function save_purchase_item_data($data)
	{
	    $this->db->insert('purchase_item_entry',$data);
        $insert_id =$this->db->insert_id();
       if($this->db->affected_rows() == '1')
    {
        return $insert_id;
    }
	}
	
	function save_purchase_suppplier_payment($initialPaymentData)
	{
	    $this->db->insert('purchase_supplier_payment',$initialPaymentData);
       if ($this->db->affected_rows() == '1')
    {
        return true;
    }
	}
    public function delete_purchase_item_data($purchaseItemId)
    {
        $this->db->where('purchase_item_entry_id ', $purchaseItemId);
        $this->db->delete('purchase_item_entry');

        return $this->db->affected_rows() > 0;
    }
    public function delete_selected_purchase_items($purchaseItemId) {
        $this->db->where('purchase_item_entry_id ', $purchaseItemId);
        $this->db->delete('purchase_item_entry');
        return $this->db->affected_rows() > 0;
    }

	function save_perchase_supplier_data1($data1)
	{
	     $this->db->insert('purchase_supplier',$data1);
        return true;
	}
	function save_purchase_transport_data($data2){
	    $this->db->insert('purchase_transport',$data2);
        return true;
	}
    function update_purchase_transport_data($data2,$id)
    {
        $this->db->where('purchase_transport_id', $id);
        $this->db->update('purchase_transport',$data2);
        return true;  
    }
	function save_barcode_data($data){
	    $this->db->insert('barcodes',$data);
        return true;
	}
	function edit_data($data,$editid){
	  $this->db->where('purchase_transport_id', $editid);
        $this->db->update('purchase_transport',$data);
        return true;  
	}
		function edit_data1($data,$editid){
	  $this->db->where('purchase_item_id', $editid);
        $this->db->update('purchase_item',$data);
        return true;  
	}

function edit_item_purchase_data($data,$purchase_item_id){
    $this->db->where('purchase_item_id', $purchase_item_id);
        $this->db->update('purchase_item',$data);
        return true;
}

function stock_status_change($data,$purchase_supplier_id){
     $this->db->where('purchase_supplier_id', $purchase_supplier_id);
        $this->db->update('purchase_supplier_payment',$data);
        return true;
}
	
	function edit_item_data($data,$purchase_item_id){
	    
	    $this->db->where('purchase_item_id', $purchase_item_id);
        $this->db->update('purchase_item',$data);
        
        return true;
	}
    function update_item_data($data,$editid){
	    
	    $this->db->where('purchase_item_entry_id', $editid);
        $this->db->update('purchase_item_entry',$data);
        return true;
	}
	 function delete_item_data($data,$purchase_item_id){
	      $this->db->where('purchase_item_id', $purchase_item_id );
		$this->db->update('purchase_item', $data);	
		return true;
	 }
	 
	function delete_purchase_data($data,$perchaseid){
	    $this->db->where('purchase_item_entry_id', $perchaseid );
		$this->db->update('purchase_item_entry', $data);	
		return true;
   }
   function get_maxid()
   {
       	$this->db->select('max(purchase_supplier_id) as maxid');
        $this->db->from('purchase_supplier');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }
   function get_super_maxid()
   {
        $this->db->where('company_name', 'supereditors' );
       	$this->db->select('*');
        $this->db->from('purchase_supplier');
        $query = $this->db->get();
        
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }
   function get_manna_maxid()
   {
       $this->db->where('company_name', 'mannasmenswear' );
       	$this->db->select('*');
        $this->db->from('purchase_supplier');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
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
        $this->db->from('items');
        $this->db->where('item_type_id',$id);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }  
   }
   public function get_tax($item, $supplier)
    {
        $this->db->select('*');
        $this->db->from('supplier as p');
        $this->db->where('p.supplier_id', $supplier);
        $this->db->where('is_active', '1');
        $result_obj = $this->db->get();
        $suppiler = is_object($result_obj) ? $result_obj->result_array() : array();
        
        $this->db->select('igst');
        $this->db->select('cgst');
        $this->db->select('sgst');
        $this->db->from('items');
        $this->db->where('item_id', $item);
        $this->db->where('is_active', '1');
        $result_obj = $this->db->get();
        $result = is_object($result_obj) ? $result_obj->result_array() : array();
        
        if (!empty($suppiler)) {
            $gst = $suppiler[0]['gst'];
            if (substr($gst, 0, 2) === "27") {
                return array($result[0]['cgst'], $result[0]['sgst']);
            } else {
                return array($result[0]['igst']);
            }
        } else {
            return false;
        }        
    }

   public function get_brandname($id1)
   {
       $this->db->select();
        $this->db->from('fabric');
        $this->db->where('brand_id',$id1);
        $this->db->where('is_active','1');
        $query = $this->db->get();
      
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }   
   }
   public function get_gst($sup_name)
   {
        $this->db->select();
        $this->db->from('supplier');
        $this->db->where('supplier_id',$sup_name);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }
   public function get_gstval($id)
   {
        $this->db->select();
        $this->db->from('supplier');
        $this->db->where('supplier_id',$id);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }

   public function get_transport_data($id)
   {
        $this->db->select();
        $this->db->from('transport');
        $this->db->where('transport_id',$id);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }
   public function edit_purchase_transport_data($data,$purchase_transport_id){
        $this->db->where('purchase_transport_id', $purchase_transport_id );
		$this->db->update('purchase_transport', $data);	
		return true;
   }
   public function edit_purchase_supplier_data($data,$purchase_item_id){
        $this->db->where('purchase_supplier_id', $purchase_item_id );
        $this->db->update('purchase_supplier', $data);
        return true;    
   }
      
    public function payment_update($data,$purchase_supplier_payment_id){
        $this->db->where('purchase_supplier_payment_id', $purchase_supplier_payment_id );
        $this->db->update('purchase_supplier_payment', $data);	
        return true;
   }
   
   
   public function advance_payment_update($voucher_no,$supplier,$adv_adjusted){
       $data = array("amount_adjusted" => $adv_adjusted);
        $this->db->where('voucher_no', $voucher_no );
         $this->db->where('supplier_id', $supplier );
	$this->db->update('advance_payment_entry', $data);	
	
		return true;
   }
   
   
   public function get_edit_gst($supplier_id){
        $this->db->select();
        $this->db->from('supplier');
        $this->db->where('supplier_id',$supplier_id);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
   }
   public function get_purchase_data($id){
       $this->db->select();
        $this->db->from('purchase_supplier');
        $this->db->where('purchase_supplier_id',$id);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        
        if( $query->num_rows() > 0 )
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