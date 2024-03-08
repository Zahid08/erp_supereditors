<?php
$purchase_item_id = $_GET["purchase_item_id"];
$purchase_supplier_id = $_GET["purchase_supplier_id"];

$perchaseDetails = $this->db->query("SELECT *,i.item_type,b.brand_name, d.item_name,s.measure_name,p.shade_no,p.no_of_packs ,p.stock_quntitiy ,p.billing_quntity ,p.quantitiy_per_pack,p.rate, p.mrp,p.discount,p.amount,p.tax_per,p.igst,p.cgst,p.sgst,p.total_tax,p.netamount,i.item_type, CASE WHEN i.item_type = 'Fabric' THEN (SELECT f.fabric_name FROM fabric f WHERE f.fabric_id = p.item_id)
    ELSE d.item_name END as item_name,s.measure_name,b.brand_name FROM purchase_item p 
INNER JOIN item_type i ON i.item_type_id = p.item_type_id 
   INNER JOIN items d ON d.item_id = p.item_id
   INNER JOIN measure s ON s.measure_id = p.measure_id 
   LEFT JOIN brand b ON b.brand_id = p.brand_id 
WHERE p.is_active = 1 AND purchase_item_id=$purchase_item_id")->result();
foreach($perchaseDetails as  $getitemtypeDetailsvalue){
 $item_type = $getitemtypeDetailsvalue->item_type;
 $brand_name = $getitemtypeDetailsvalue->brand_name;
 $item_name = $getitemtypeDetailsvalue->item_name;
}

$measureDetails = $this->db->query("SELECT * FROM measure WHERE is_active = 1")->result();
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();



$itemnameDetails = $this->db->query("SELECT * FROM items WHERE is_active = 1")->result();
$brandDetails = $this->db->query("SELECT * FROM brand WHERE is_active = 1")->result();
$purchaseitemDetails=$this->db->query("SELECT * FROM purchase_supplier WHERE purchase_supplier_id = $purchase_supplier_id")->result();
 foreach($purchaseitemDetails as $getpurchaseitemDetails){
      $supplier_id = $getpurchaseitemDetails->supplier_id;
 }
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
    <title>SuperEditors || Roles Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">a
    
    
</head>

<body class="header-fix fix-sidebar">
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
       <?php include("includes/header.php") ?>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <?php include("includes/sidenav.php") ?>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Measue</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Item</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <center>
                    <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
                </center>
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                    <h5 class="card-title"><b>Item</b></h5>
                     <?php foreach($perchaseDetails as $getperchaseDetails){ 
                         
                      ?>
               
                    <center>
            <p style="color:green"><?php echo $this->session->flashdata('purchase_message1') ?></p>
          </center>
                   <form method="post" action="<?php echo base_url() ?>Purchase/edit_purchase_item_data" autocomplete="off">
                   
                   <div class="row">
                      <div class="col-sm-12">
                                 <input class="form-control" type="hidden" name="purchase_supplier_id" id="purchase_supplier_id" value="<?php echo $_GET['purchase_supplier_id'] ?>">
                              
                                 <input class="form-control" type="hidden" name="purchase_item_id" id="purchase_item_id" value="<?php echo $getperchaseDetails->purchase_item_id ?> ">
                              </div>
                 
                        <div class="col-sm-4 mt-2">
          <label>Item Type</label>
               <input class="form-control" type="text" name="item_type" value="<?php echo $item_type; ?>" id="item_type" readonly required>
    
        </div> 
        <div class="col-sm-4 mt-2 ">
         <?php if($item_type == Fabric){
         ?>
         <label>Brand Name</label>
  <input class="form-control" type="text" name="brand_name" value="<?php echo $brand_name; ?>" id="brand_name" readonly required>
    <?php    } else{
                           
                ?>
              
         <div class="appending_div"></div>
         <?php } ?>
      </div> 
        <div class="col-sm-4 mt-2">
         <label>Item Name</label>
         <input class="form-control" type="text" name="item_name" value="<?php echo $item_name; ?>" id="item_name" readonly required>
      </div> 
         
         <div class="col-sm-4 mt-2">
       <label>Size</label>
       <select class="form-control" name="size" id="size" value="<?php echo $getperchaseDetails-> measure_name ?>"  required>
         <option>Size</option>


          <?php foreach($measureDetails as $getmeasureDetails){ ?>
              <option value="<?php echo $getmeasureDetails->measure_id ?>" <?php if($getperchaseDetails->measure_name == $getmeasureDetails->measure_name)
              { ?> selected <?php } ?>><?php echo $getmeasureDetails->measure_name  ?></option>
            <?php } ?>
      </select>
    </div> 
    <div class="col-sm-4 mt-2"> 
      <label>Shade No/Color</label>
      <input class="form-control" type="text" name="shade_no" value="<?php echo $getperchaseDetails->shade_no ?>" id="shade_no"  placeholder="Shade No/Color" >
    </div>
    <div class="col-sm-4 mt-2"> 
      <label>Number Of Pack</label>
      <input class="form-control" type="number" name="no_packs" value="<?php echo $getperchaseDetails->no_of_packs ?>"  id="no_packs"  placeholder="Number of packs" readonly required>
    </div> 
     <div class="col-sm-4 mt-2">
     <label>Stock Quantity</label>
     <input class="form-control" type="number" name="Stock_qty" value="<?php echo $getperchaseDetails->stock_quntitiy ?>" id="Stock_qty" placeholder="Stock Quantity"    required>
   </div>      
   <div class="col-sm-4 mt-2">
     <label>Billling Quantity</label>
     <input class="form-control" type="number" name="billing_qty" value="<?php echo $getperchaseDetails->billing_quntity ?>" id="billling_qty" placeholder="Billing Qty" readonly required>
   </div>      
   <div class="col-sm-4 mt-2">
     <label>Quantity Per Pack</label>
     <input class="form-control" type="number" name="Qty_per_pack" value="<?php echo $getperchaseDetails->quantitiy_per_pack ?>" id="Qty_per_pack" placeholder="Qty per pack" readonly required>
   </div>
    
    
   <div class="col-sm-4 mt-2">
    <label>Rate</label>
    <input class="form-control" type="number" name="rate" id="rate" value="<?php echo $getperchaseDetails->rate ?>" placeholder="Rate" required>
  </div>    
 
  <div class="col-sm-4 mt-2">
   <label>MRP</label>
   <input class="form-control" type="number" name="mrp" id="mrp" value="<?php echo $getperchaseDetails->mrp ?>" placeholder="MRP"    required>
 </div> 
  <div class="col-sm-4 mt-2">
   <label>Discount</label>
   <input class="form-control" type="number" name="discount" id="discount" value="<?php echo $getperchaseDetails->discount ?>" placeholder="Discount"    required>
 </div> 
 <div class="col-sm-4 mt-2">
  <label> Amount</label>
  <input class="form-control" type="number" name="amount" id="amount" value="<?php echo $getperchaseDetails->amount ?>"   placeholder="Amount" readonly required>
</div>

<div class="col-sm-4 mt-2">
  <label>Tax Per (in %)</label>
  <input class="form-control" type="number" name="tax_per" value="<?php echo $getperchaseDetails->tax_per ?>" id="tax_per"  placeholder="Tax Per " readonly  required>
</div> 
<div class="col-sm-4 mt-2">
  <label>IGST</label>
  <input class="form-control" type="number" name="total_igst" id="total_igst" value="<?php echo $getperchaseDetails->igst ?>" placeholder="IGST"  readonly  required>
</div> 
<div class="col-sm-4 mt-2">
 <label> CGST</label>
 <input class="form-control" type="number" name="total_cgst" value="<?php echo $getperchaseDetails->cgst ?>"  id="total_cgst" placeholder="CGST" readonly  required>
</div>      
<div class="col-sm-4 mt-2">
  <label>SGST</label>
  <input class="form-control" type="number" name="total_sgst" value="<?php echo $getperchaseDetails->sgst ?>" id="total_sgst" placeholder="SGSt" readonly required>
</div> 
<div class="col-sm-4 mt-2">
 <label>Total Tax</label>
 <input class="form-control" type="number" name="total_tax" id="total_tax" value="<?php echo $getperchaseDetails->total_tax ?>" placeholder="Total Tax" readonly  required>
</div> 
 <div class="col-sm-4 mt-2">
  <label>Net Amount</label>
  <input class="form-control" type="number" name="netamount" id="netamount"  value="<?php echo $getperchaseDetails->netamount ?>"  placeholder="Amount" readonly required>
</div>
 <div class=" mt-5 col-sm-12">
 <button  type="submit"  class=" btn btn-primary   ">Save</button>
                                    
</div>
</form>
 <?php } ?>
                  </div>
               </div>
            </section>
               
            
            <!-- Start Page Content -->   
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    
    <!-- Scripts -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
        <!-- scripit init-->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/dashboard-1.js"></script>
        
        <!-- Data Tables-->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables-init.js"></script>
       <script>
            $(document).ready(function (){
                 $('#item_type').change(function(){
      
    var id = $(this).val();
     
    var sup_name = $('#supplier_name').find(":selected").val();

    var url = "<?php echo base_url('Purchase/get_itemname'); ?>";
    var post_data = {
        'id': id,
        'sup_name': sup_name,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
    };
    
    $.ajax({
     url : url,
     type : 'POST',
     data: post_data,
     success : function(result)
     {
         
         var obj = JSON.parse(result);
         $('#item_name').find('option').remove();
         $('#item_name').append($('<option/>', { 
                value: '0',
                text : 'Select Item Name'
            }));
         for(var i=0;i<obj.length;i++)
         {
		    $('#item_name').append($('<option/>', { 
                value: obj[i]['item_id'],
                text : obj[i]['item_name']
            }));
         }
         if(id == '3')
         {
              var field ='<label>Brand Name</label><select  class="form-control" value="<?php echo $getperchaseDetails-> brand_name ?>" name="brand_name" id="brand_name" onchange="function1(this)" placeholder="Brand Name" ><?php foreach($brandDetails as $getbrandDetails){ ?><option value="<?php echo $getbrandDetails->brand_id ?>" <?php if($getperchaseDetails->brand_name == $getbrandDetails->brand_name){ ?> selected <?php } ?>><?php echo $getbrandDetails->brand_name  ?></option><?php } ?></select>';
    $(".appending_div").html(field);
 
 
  
         }
         else{
              var field ='<label>Brand Name</label><select class="form-control" name="brand_name" id="brand_name" onchange="myFunction() placeholder="Brand Name" ><?php foreach($brandDetails as $getbrandDetails){ ?><option value="<?php echo $getbrandDetails->brand_id ?>" <?php if($getperchaseDetails->brand_name == $getbrandDetails->brand_name){ ?> selected <?php } ?>><?php echo $getbrandDetails->brand_name  ?></option><?php } ?></select>';
    $(".appending_div").html('');

         }
     }

  });
  
  });
    });
    
             $('#billling_qty').focusout(function()
           {
              
                var billing_qty = $(this).val();
                
            
                 var no_packs = $('#no_packs').val();
                
                 var qty_per_pack = (billing_qty)/(no_packs);
                
                 $('#Qty_per_pack').val(qty_per_pack);
                 
           });
               $('#mrp').focusout(function()
   {
        var discount = $(this).val();
         var rate =  $('#rate').val();
        //var Stock_qty = $('#Stock_qty').val();
        var billing_qty = $('#billling_qty').val();
         var discount = $('#discount').val();
        
       
        var total_amount = rate * billing_qty;
     //alert(total_amount);
        var discount_amount = ((discount)*(1/100)) * (total_amount);
        //alert(discount_amount);
        total_amount = total_amount - discount_amount;
        $('#amount').val(total_amount);
         var total_tax = $('#total_tax').val();
        var amount = $('#amount').val();
    
          var supplier_id = <?php echo $supplier_id ?>;


     var url = "<?php echo base_url('Purchase/get_edit_gst'); ?>";
     var post_data = {
        'supplier_id': supplier_id,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        };
    
        $.ajax({
        url : url,
        type : 'POST',
        data: post_data,
        success : function(result)
        { 
            
            //$('#gst_tpt').val(obj[0]['gst']);
            
           var obj = JSON.parse(result);
         
        if(obj[0]['state_id'] == '21')
        {   
   
               var cgst = obj[0]['gst'] / 2;
        var sgst = obj[0]['gst'] / 2;
      
             var aftercgst = (cgst)*(1/100) * (total_amount);
           
           var aftersgst = (sgst)*(1/100) * (total_amount);
           
                $('#total_cgst').val(aftercgst);
                $('#total_sgst').val(aftercgst);
                $('#total_igst').val(0);
                 var total_tax_supp =aftercgst +aftersgst;
                  $('#total_tax').val(total_tax_supp);
        
            }
            else
            {
                
                var igst = obj[0]['gst'] ;
                 var afterigst = (igst)*(1/100) * total_amount;
                 $('#total_cgst').val(0);
                $('#total_sgst').val(0);
                $('#total_igst').val(afterigst);
            var total_tax_supp =  afterigst;
             $('#total_tax').val(afterigst);
             
        
            }
        
         
          var netamount = (total_amount)+ (total_tax_supp);
        $('#netamount').val(Math.round(netamount));
        }
        

    });
    
        
        
          
      
          
        //$('#total_tax').val(total_tax_amount);
        //var lr_amout = $('#lr_amout').val();
        //var amount = $('#amount').val();
        //var total_tpt_tax = $('#total_tpt_tax').val();
        //var net_total = (total_tpt_tax) + (total_tax_amount) + (lr_amout) + (amount);
        //$('#net_amount').val(net_total);
   });
     $('#discount').focusout(function()
   {
        var discount = $(this).val();
         var rate =  $('#rate').val();
        //var Stock_qty = $('#Stock_qty').val();
        var billing_qty = $('#billling_qty').val();
         var discount = $('#discount').val();
        
       
        var total_amount = rate * billing_qty;
     //alert(total_amount);
        var discount_amount = ((discount)*(1/100)) * (total_amount);
        //alert(discount_amount);
        total_amount = total_amount - discount_amount;
        $('#amount').val(total_amount);
         var total_tax = $('#total_tax').val();
        var amount = $('#amount').val();
    
          var supplier_id = <?php echo $supplier_id ?>;


     var url = "<?php echo base_url('Purchase/get_edit_gst'); ?>";
     var post_data = {
        'supplier_id': supplier_id,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        };
    
        $.ajax({
        url : url,
        type : 'POST',
        data: post_data,
        success : function(result)
        { 
            
            //$('#gst_tpt').val(obj[0]['gst']);
            
           var obj = JSON.parse(result);
         
        if(obj[0]['state_id'] == '21')
        {   
   
               var cgst = obj[0]['gst'] / 2;
        var sgst = obj[0]['gst'] / 2;
      
             var aftercgst = (cgst)*(1/100) * (total_amount);
           
           var aftersgst = (sgst)*(1/100) * (total_amount);
           
                $('#total_cgst').val(aftercgst);
                $('#total_sgst').val(aftercgst);
                $('#total_igst').val(0);
                 var total_tax_supp =aftercgst +aftersgst;
                  $('#total_tax').val(total_tax_supp);
        
            }
            else
            {
                
                var igst = obj[0]['gst'] ;
                 var afterigst = (igst)*(1/100) * total_amount;
                 $('#total_cgst').val(0);
                $('#total_sgst').val(0);
                $('#total_igst').val(afterigst);
            var total_tax_supp =  afterigst;
             $('#total_tax').val(afterigst);
             
        
            }
        
         
          var netamount = (total_amount)+ (total_tax_supp);
         $('#netamount').val(Math.round(netamount));
        
        }
        

    });
    
        
        
          
      
          
        //$('#total_tax').val(total_tax_amount);
        //var lr_amout = $('#lr_amout').val();
        //var amount = $('#amount').val();
        //var total_tpt_tax = $('#total_tpt_tax').val();
        //var net_total = (total_tpt_tax) + (total_tax_amount) + (lr_amout) + (amount);
        //$('#net_amount').val(net_total);
   });
            function function1(obj){
     
  //$('#brand_name').change(function(){
     //alert("ok");
      var id1 = $(obj).val();
     
    var sup_name = $('#supplier_name').find(":selected").val();
    var url = "<?php echo base_url('Purchase/get_brandname'); ?>";
     var post_data = {
        'id1': id1,
        'sup_name': sup_name,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
    };
        $.ajax({
     url : url,
     type : 'POST',
     data: post_data,
     success : function(result)
     {
        
         var obj = JSON.parse(result);
         $('#item_name').find('option').remove();
         $('#item_name').append($('<option/>', { 
                value: '0',
                text : 'Select Item Name'
            }));
         for(var i=0;i<obj.length;i++)
         {
		    $('#item_name').append($('<option/>', { 
                value: obj[i]['fabric_id'],
                text : obj[i]['fabric_name']
            }));
         }
        
         
     }

  });
      
 // });
 }
 
       </script>
 
   
</body>

</html>