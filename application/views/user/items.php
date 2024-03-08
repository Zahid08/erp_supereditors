<?php
error_reporting(1);
$rolesDetails = $this->db->query("SELECT * FROM roles r LEFT JOIN user u ON u.user_id = r.created_by WHERE r.is_active = 1 ORDER BY id DESC")->result();
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
    <title>SuperEditors || Items Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
     <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    
    
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
                    <h3 class="text-primary">Items</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Items</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <a href="<?php echo base_url()?>Items/add_item" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Items</button></a>
                
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('item_message') ?></p>
                </center>
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Items</h4>
                              
                              <div class="panel-group" id="accordion">
                                  
                                  <?php foreach($item_data as $key=>$item_type){ 
                                  if($key == 0)
                                  {
                                  ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a class="link_head" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse'.$key; ?>"><?php echo ucwords($item_type['type']['item_type']); ?></a>
          <button class="delete_type" id="<?php echo $item_type['type']['item_type_id']; ?>" data-toggle="modal" data-target="#deletetypeModal"><i class="fa fa-trash text-white"></i></button>
          <button class="add_name_type" id="<?php echo $item_type['type']['item_type_id']; ?>" data-toggle="modal" data-target="#addNameModal"><i class="fa fa-plus text-white"></i></button>
        </h4>
      </div>
      <div id="<?php echo 'collapse'.$key; ?>" class="panel-collapse collapse ">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                                            <tr>
                                                <th>Items Name</th>
                                                <th>HSN </th>
                                                <th>IGST</th>
                                                <th>CGST</th>
                                                <th>SGST</th>
                                                <th>Created By</th>
                                                <th>Created Date Time</th>
                                                <th>View Access</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($item_type['name'] as $name_key => $name_value)
                                            {
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($name_value['item_name']); ?></td>
                                                <td><?php echo $name_value['hsn_code']; ?></td>
                                                <td><?php echo $name_value['igst']; ?></td>
                                                <td><?php echo $name_value['cgst']; ?></td>
                                                <td><?php echo $name_value['sgst']; ?></td>
                                                <td><?php echo $name_value['uname']; ?></td>
                                                <td><?php echo date_format(date_create($name_value['created_date']),"d-m-Y"); ?></td>
                                                <td>
                                                    <button class="btn btn-primary editname" id="<?php echo $name_value['item_id']; ?>"  data-id="<?php echo $name_value['item_name']; ?>" data-id1="<?php echo $name_value['hsn_code']; ?>" data-id2="<?php echo $name_value['igst'];?>" data-id3="<?php echo $name_value['cgst'];?>" data-id4="<?php echo $name_value['sgst']; ?>"  data-toggle="modal" data-target="#editModal"><i class="fa fa-edit text-black"></i></button>
                                                    <button class="btn btn-primary deletename" id="<?php echo $name_value['item_id']; ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-black"></i></button>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                            
                </table>
            </div>
        </div>
      </div>
    </div>
    <?php
                                  }
    else
    {
        ?>
            <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a class="link_head" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse'.$key; ?>"><?php echo ucwords($item_type['type']['item_type']); ?></a>
            <button class="delete_type" id="<?php echo $item_type['type']['item_type_id']; ?>" data-toggle="modal" data-target="#deletetypeModal"><i class="fa fa-trash text-white"></i></button>
            <button class="add_name_type" id="<?php echo $item_type['type']['item_type_id']; ?>" data-toggle="modal" data-target="#addNameModal"><i class="fa fa-plus text-white"></i></button>
        </h4>
      </div>
      <div id="<?php echo 'collapse'.$key; ?>" class="panel-collapse collapse">
        <div class="panel-body">
                        <div class="table-responsive">
                <table class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                                            <tr>
                                                <th>Items Name</th>
                                                <th>HSN </th>
                                                <th>IGST</th>
                                                <th>CGST</th>
                                                <th>SGST</th>
                                                <th>Created By</th>
                                                <th>Created Date Time</th>
                                                <th>View Access</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($item_type['name'] as $name_key => $name_value)
                                            {
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($name_value['item_name']); ?></td>
                                                <td><?php echo $name_value['hsn_code']; ?></td>
                                                <td><?php echo $name_value['igst']; ?></td>
                                                <td><?php echo $name_value['cgst']; ?></td>
                                                <td><?php echo $name_value['sgst']; ?></td>
                                                <td><?php echo $name_value['uname']; ?></td>
                                                <td><?php echo date_format(date_create($name_value['created_date']),"d-m-Y"); ?></td>
                                                <td>
                                                     <button class="btn btn-primary editname" id="<?php echo $name_value['item_id']; ?>" data-id="<?php echo $name_value['item_name']; ?>" data-id1="<?php echo $name_value['hsn_code']; ?>" data-id2="<?php echo $name_value['igst'];?>" data-id3="<?php echo $name_value['cgst'];?>" data-id4="<?php echo $name_value['sgst']; ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit text-black"></i></button>
                                                    <button class="btn btn-primary deletename" id="<?php echo $name_value['item_id']; ?>" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash text-black"></i></button>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                            
                </table>
            </div>
        </div>
      </div>
    </div>
        <?php
    }
                                      
                                 }
    ?>

  </div> 

                             
                              
  
                            </div>
                        </div>    
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    
    
    
    
    <div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Item</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          
          <label>Item Name</label>
        <input type="text" name="item_edit_name" id="item_edit_name" class="form-control" required>
        <input type="hidden" name="item_edit_id" id="item_edit_id" required>
           <label>HSN 1</label>
        <input type="text" name="item_edit_hsn1" id="item_edit_hsn1" class="form-control" required>
      <label>IGST 1</label>
        <input type="text" name="item_edit_igst" id="item_edit_igst" class="form-control" required>
        <label>CGST 1</label>
        <input type="text" name="item_edit_cgst" id="item_edit_cgst" class="form-control" required>
        <label>SGST 1</label>
        <input type="text" name="item_edit_sgst" id="item_edit_sgst" class="form-control" required>
      </div>
      

      <!-- Modal footer -->
      <div class="modal-footer">
         <button type="button" class="btn btn-primary edit_item_save" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

    
    <div class="modal" id="addNameModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Item</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         
          <label>Item Name</label>
        <input type="text" name="item_add_name" id="item_add_name" class="form-control" required>
        <input type="hidden" name="item_addnameType_id" id="item_addnameType_id" required>
         <label>HSN CODE</label>
        <input type="text" name="item_hsn_code" id="item_hsn_code" class="form-control" required>
         <label>IGST</label>
        <input type="text" name="item_igst" id="item_igst" class="form-control" required>
         <label>CGST</label>
        <input type="text" name="item_cgst" id="item_cgst" class="form-control" required>
         <label>SGST</label>
        <input type="text" name="item_sgst" id="item_sgst" class="form-control" required>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
         <button type="button" class="btn btn-primary add_item_name_save" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Item</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
       <input type="hidden" name="item_delete_id" id="item_delete_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-primary delete_item_save" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
   
   
   <div class="modal" id="deletetypeModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Item</h4>
        <button type="button" class="btn close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
       <input type="hidden" name="item_deletetype_id" id="item_deletetype_id" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-primary item_deletetype_save" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
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
        <!--<script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables-init.js"></script>-->
       
 <script>
     
      $(document).ready(function() {
  $('.editname').click(function() {
     
     var id = $(this).attr('id'); 
     $('#item_edit_id').val(id);
     
     var item_name = $(this).attr('data-id'); 
     $('#item_edit_name').val(item_name);
     
      var hsn_code = $(this).attr('data-id1'); 
     $('#item_edit_hsn1').val(hsn_code);
      
        var igst = $(this).attr('data-id2'); 
     $('#item_edit_igst').val(igst);
     
      var cgst = $(this).attr('data-id3'); 
     $('#item_edit_cgst').val(cgst);
     
      var sgst = $(this).attr('data-id4'); 
     $('#item_edit_sgst').val(sgst);
     
    
      
      
      
  });
  
  $('.deletename').click(function()
  {
     var id = $(this).attr('id'); 
     $('#item_delete_id').val(id);
  });
  
  $('.delete_type').click(function()
  {
      var type_id = $(this).attr('id');
        $('#item_deletetype_id').val(type_id);
  });
  $('.add_name_type').click(function()
  {
      var type_id = $(this).attr('id');
        $('#item_addnameType_id').val(type_id);
  });
  
  $('.item_deletetype_save').click(function()
  {
        var type_id = $('#item_deletetype_id').val();  
     
     	var url = '<?php echo base_url();?>Items/delete_type';

					var post_data = {
						'type_id': type_id,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Item Type deleted successfully.');
								window.location.replace('<?php echo base_url(); ?>Items');
							}else{
								alert("Failed to delete the Item Type...Try again");
								window.location.replace('<?php echo base_url(); ?>Items');
							}
						}
					});
     
  });
  
  
  $('.add_item_name_save').click(function()
  {
            var id = $('#item_addnameType_id').val();
            
     var name = $('#item_add_name').val();
     var hsn_code = $('#item_hsn_code').val();
      var igst = $('#item_igst').val();
       var cgst = $('#item_cgst').val();
        var sgst = $('#item_sgst').val();
       
      					var url = '<?php echo base_url();?>Items/add_name_item';

					var post_data = {
						'item_addnameType_id': id,
						'item_add_name':name,
						'item_hsn_code':hsn_code,
						'item_igst':igst,
						'item_cgst':cgst,
						'item_sgst':sgst,
						
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Item added successfully.');
								window.location.replace('<?php echo base_url(); ?>Items');
							}else{
								alert("Failed to add the Item...Try again");
								window.location.replace('<?php echo base_url(); ?>Items');
							}
						}
					});
  });
  
  $('.edit_item_save').click(function()
  {
      var id = $('#item_edit_id').val();
     var name = $('#item_edit_name').val();
      var hsn1 = $('#item_edit_hsn1').val();
      var igst  = $('#item_edit_igst').val();
      var cgst = $('#item_edit_cgst').val();
      var sgst = $('#item_edit_sgst').val();
      
      					var url = '<?php echo base_url();?>Items/edit_item';

					var post_data = {
						'item_edit_id': id,
						'item_edit_name':name,
						'item_edit_hsn1':hsn1,
						'item_edit_igst':igst,
						'item_edit_cgst':cgst,
						'item_edit_sgst':sgst,
					
					    
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Item updated successfully.');
								window.location.replace('<?php echo base_url(); ?>Items');
							}else{
								alert("Failed to update the Item...Try again");
								window.location.replace('<?php echo base_url(); ?>Items');
							}
						}
					});
  });
  
    $('.delete_item_save').click(function()
  {
      var id = $('#item_delete_id').val();
      
      					var url = '<?php echo base_url();?>Items/delete_item';

					var post_data = {
						'item_edit_id': id,
					};
					$.ajax({
						url : url,
						type : 'post',
						data :post_data,
						success : function(responce){
							if(responce==1){
								alert('Item deleted successfully.');
								window.location.replace('<?php echo base_url(); ?>Items');
							}else{
								alert("Failed to delete the Item...Try again");
								window.location.replace('<?php echo base_url(); ?>Items');
							}
						}
					});
  });
      });
     
 </script>
   
</body>

</html>